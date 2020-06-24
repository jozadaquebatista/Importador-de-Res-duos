<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\Spreadsheets;

class Waste extends Model
{

	use Spreadsheets;
	use SoftDeletes;

	protected $fillable = [
        'residuo',
		'tipo',
		'categoria',
		'tratamento',
		'classe',
		'unidade',
		'peso'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
}