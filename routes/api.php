<?php

use App\Http\Controllers\LocalityController;
use App\Models\FederalEntity;
use App\Models\Locality;
use App\Models\Municipality;
use App\Models\SettlementType;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;


Route::get('zip-codes/{zip_code}', [LocalityController::class, 'show']);
Route::get('import-localidades-from-excel/{from}/{to}', [LocalityController::class, 'importLocalities']);
Route::get('save-localities-in-cache', [LocalityController::class, 'saveLocalitiesInCache']);
