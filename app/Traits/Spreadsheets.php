<?php

namespace App\Traits;

use Illuminate\Http\Request;
use File;

trait Spreadsheets {

	public function formatSpreadsheet(Array $file)
    {
        if(is_null($file) && empty($file)) throw new \Exception('file is missing.');

        $datasheet = array_filter($file, function($array) {

            $length = array_filter($array, function($item) {
                return !is_null($item);
            });

            return count($length) > 0 ? $length : false;
        });

        $datasheet = array_values($datasheet);

        if(!is_null($datasheet[0]))
        {
            $headerSize = array_filter($datasheet[0], function($item) {
                return !is_null($item);
            });

            $headerSize = count($headerSize);
        }

        array_shift($datasheet);

        $datasheet = array_map(function($array) use ($headerSize) {
            return array_slice($array, -$headerSize);
        }, $datasheet);

        return $datasheet;
    }

    public function saveSpreadsheet(Request $request)
    {
        $fileName = time() . '.' . $request->file('spreadsheet')->extension();
        $path = storage_path('app\public');

        if(!File::isDirectory($path))
        {
            File::makeDirectory($path, 0777, true, true);
        }

        $request->file('spreadsheet')->move($path , $fileName);

        return $fileName;
    }
}