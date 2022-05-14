<?php

use App\Http\Controllers\LocalityController;
use App\Models\FederalEntity;
use App\Models\Locality;
use App\Models\Municipality;
use App\Models\SettlementType;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;


Route::get('zip-codes/{zip_code}', [LocalityController::class, 'show']);
Route::get('save-localities-in-cache', [LocalityController::class, 'saveLocalitiesInCache']);
