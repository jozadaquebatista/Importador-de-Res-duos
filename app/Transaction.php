<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'hash',
        'waste_id'
    ];

    protected $hidden = [
        'waste_id', 'created_at', 'updated_at'
    ];

    public function waste()
    {
    	return $this->belongsTo(Waste::class);
    }
}
