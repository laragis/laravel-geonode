<?php

use Illuminate\Support\Facades\Route;
use TungTT\LaravelGeoNode\Http\Controllers\ResourceController;

Route::middleware('web')->group(function(){

    Route::get('/geonode/api/resources', [ResourceController::class, 'index']);

});

