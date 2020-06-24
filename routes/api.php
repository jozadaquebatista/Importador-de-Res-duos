<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Wastes API
Route::group(['prefix' => 'v1'], function() {
	// This route points to a resource controller
	Route::resource('wastes', 'Wastes');
});