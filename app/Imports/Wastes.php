<?php

namespace App\Imports;

use App\Waste;
use Maatwebsite\Excel\Concerns\ToModel;

class Wastes implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Waste([
            'residuo' => $row[0],
            'tipo' => $row[1],
            'categoria' => $row[2],
            'tratamento' => $row[3],
            'classe' => $row[4],
            'unidade' => $row[5],
            'peso' => $row[6]
        ]);
    }
}