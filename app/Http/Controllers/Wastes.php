<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

use App\Waste;
use App\Transaction;

use App\Jobs\Wastes as WastesJob;
use App\Imports\Wastes as WastesImport;

use File;

class Wastes extends Controller
{
    private $response;
    private $contentType;

    public function __construct(Request $request)
    {
        $this->contentType = $request->method() == 'POST' ?
                        preg_match('/multipart\/form-data/', $request->header('content-type')) :
                        preg_match('/application\/json/', $request->header('content-type'));

        $this->response = [
            'status' => 200
        ];
    }

    public function index()
    {
        if($this->contentType)
        {
            $data = Waste::paginate();
            $this->response['success'] = [$data];
        } else {
            $this->response['status'] = 400;
            $this->response['message'] = 'invalid Content-Type.';
        }

        return response($this->response, $this->response['status']);
    }

    public function show($transaction)
    {
        if($this->contentType)
        {
            $data = Transaction::where('hash', $transaction)->with('waste')->get();
            $this->response['success'] = [$data];
        } else {
            $this->response['status'] = 400;
            $this->response['message'] = 'invalid Content-Type.';
        }

        return response($this->response, $this->response['status']);
    }

    public function store(Request $request, Waste $model)
    {
        if($this->contentType)
        {
            if($request->hasFile('spreadsheet'))
            {
                try {
                    $fileName = $model->saveSpreadsheet($request);

                    // This transaction ID will be used to identify the current transaction(spreadsheet)
                    // Because waste ID still not exists until Job end to run 
                    $this->response['transaction'] = uniqid(time() . '-') . implode('-', explode(' ', microtime())) . '-' . rand();

                    $this->dispatch(new WastesJob($fileName, $this->response['transaction']));

                } catch(\Exception $e) {
                    $this->response['error'] = 'an error ocurred when trying to import the spreadsheet.';
                }
            } else {
                $this->response['status'] = 400;
            }

        } else {
            $this->response['status'] = 400;
            $this->response['message'] = 'invalid Content-Type.';
        }

    	return response($this->response, $this->response['status']);
    }

    public function update(Request $request)
    {
        // redirects to store, because store calls eloquent createOrUpdate()
        return $this->store($request);
    }

    public function destroy($id)
    {
        if($this->contentType)
        {
            // delete() will mark(soft delete) as delete_at in the database row rather than truely deletes from world
            try {
                Waste::withTrashed()->find($id)->delete();
            } catch(\Exception $e) {
                $this->response['message'] = 'No error, but inexistent waste.';
            }
        } else {
            $this->response['status'] = 400;
            $this->response['message'] = 'invalid Content-Type.';
        }

        return response($this->response, $this->response['status']);
    }
}