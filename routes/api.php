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

Route::get('add-settlements', function () {
    Cache::forget('locality-76000');
    $localityInput = [
        "zip_code" => "76000",
        "locality" => "SANTIAGO DE QUERETARO",
        "federal_entity" => [
            "key" => 22,
            "name" => "QUERETARO",
            "code" => null
        ],
        "settlements" => [
            [
                "key" => 1,
                "name" => "CENTRO",
                "zone_type" => "URBANO",
                "settlement_type" => [
                    "name" => "Colonia"
                ]
            ],
            [
                "key" => 27,
                "name" => "SAN JOSE INN",
                "zone_type" => "URBANO",
                "settlement_type" => [
                    "name" => "Colonia"
                ]
            ],
            [
                "key" => 808,
                "name" => "LA CRUZ",
                "zone_type" => "URBANO",
                "settlement_type" => [
                    "name" => "Fraccionamiento"
                ]
            ],
            [
                "key" => 1199,
                "name" => "RINCON DE SAN ANDRES",
                "zone_type" => "URBANO",
                "settlement_type" => [
                    "name" => "Fraccionamiento"
                ]
            ],
            [
                "key" => 1681,
                "name" => "MARIANO ESCOBEDO",
                "zone_type" => "URBANO",
                "settlement_type" => [
                    "name" => "Unidad habitacional"
                ]
            ],
            [
                "key" => 1682,
                "name" => "VICENTE GUERRERO",
                "zone_type" => "URBANO",
                "settlement_type" => [
                    "name" => "Unidad habitacional"
                ]
            ],
            [
                "key" => 1683,
                "name" => "RINCONADA DE MORELOS",
                "zone_type" => "URBANO",
                "settlement_type" => [
                    "name" => "Unidad habitacional"
                ]
            ]
        ],
        "municipality" => [
            "key" => 14,
            "name" => "QUERETARO"
        ]
    ];


    $locality = Locality::firstWhere('zip_code', $localityInput['zip_code']);

    if($locality) {

    
        $locality = $locality ? $locality : new Locality;
        $locality->zip_code = $localityInput['zip_code'];
        $locality->locality = $localityInput['locality'];
        $locality->federal_entity_id = FederalEntity::updateOrCreate(
                                            [
                                                'name' => $localityInput['federal_entity']['name'],
                                            ],
                                            [
                                                'key' => $localityInput['federal_entity']['key'],
                                                'code' => $localityInput['federal_entity']['code']
                                            ]
                                        )->key;
        $locality->municipality_id = Municipality::updateOrCreate(
                                        [
                                            'name' => $localityInput['municipality']['name'],
                                        ],
                                        [
                                            'key' => $localityInput['municipality']['key']
                                        ]
                                    )->id;
        
        $locality->save();

    }

    foreach ($localityInput['settlements'] as $settlement) {
        # code...
        $locality->settlements()->updateOrCreate(
                                    [
                                        'key' => $settlement['key'],
                                    ],
                                    [
                                        'zone_type' => $settlement['zone_type'],
                                        'name' => $settlement['name'],
                                        'settlement_type_id' => SettlementType::updateOrCreate(['name' => $settlement['settlement_type']['name']])->id
                                    ]
                                );
    }

    $locality = Cache::rememberForever("locality-76000", function () {
        return Locality::where('zip_code', 76000)
            ->with([
                'federal_entity:key,name,code',
                'settlements',
                'settlements.settlement_type:id,name',
                'municipality:id,key,name'
            ])->firstOrFail();
    });

    return response()->json('Listo!');
});
