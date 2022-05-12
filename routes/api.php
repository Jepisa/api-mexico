<?php

use App\Http\Controllers\LocalityController;
use Illuminate\Support\Facades\Route;


Route::get('zip-codes/{zip_code}', [LocalityController::class, 'show']);
Route::get('import-localidades-from-excel', [LocalityController::class, 'importLocalities']);
Route::get('save-localities-in-cache', [LocalityController::class, 'saveLocalitiesInCache']);
