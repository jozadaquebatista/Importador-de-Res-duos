<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Maatwebsite\Excel\Facades\Excel;

use App\Waste;
use App\Transaction;

use App\Imports\Wastes as WastesImport;

use File;

class Wastes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $spreadsheet;
    private $transaction;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($fileName, $transaction)
    {
        $this->spreadsheet = $fileName;
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Waste $model, Transaction $transaction)
    {
        $filePath = storage_path('app\public\\') . $this->spreadsheet;

        // converts spreadsheet to array
        $originalSpreadsheet = Excel::toArray(new WastesImport, $filePath)[0];

        try {
            // formatSpreadsheet() Tries to recover spreadsheet if it is misplaced
            $cleanedSpreadsheet = $model->formatSpreadsheet($originalSpreadsheet);
            $spreadsheetFormated = true;
        } catch(\Exception $e) {
            $spreadsheetFormated = false;
        }

        if($spreadsheetFormated)
        {
            $fields = $model->getFillable();

            foreach ($cleanedSpreadsheet as $row)
            {
                // clean classe field
                $row[4] = preg_replace('/[\|,-]/','', $row[4]);

                $data = array_combine($fields,$row);

                try {

                    $id = $model->updateOrCreate($data,$data)->id;
                    $transaction->create(['hash' => $this->transaction, 'waste_id' => $id]);

                } catch(\Exception $e) {
                    // could be used to store log information like date, time, client info and payload, which waste failed, etc...
                }
            }

        }

        File::delete($filePath);
    }
}