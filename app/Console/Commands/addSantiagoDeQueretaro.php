<?php

namespace App\Console\Commands;

use App\Models\FederalEntity;
use App\Models\Locality;
use App\Models\Municipality;
use App\Models\SettlementType;
use Illuminate\Console\Command;

class addSantiagoDeQueretaro extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'locality:add-santiago-de-queretaro';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
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
    
        if(!$locality) {
            $this->info("Creando la locality");
            $locality = new Locality;
            $locality->zip_code = $localityInput['zip_code'];
            $locality->locality = $localityInput['locality'];
            $locality->federal_entity_id = FederalEntity::firstOrCreate(
                                                [
                                                    'name' => $localityInput['federal_entity']['name'],
                                                ],
                                                [
                                                    'key' => $localityInput['federal_entity']['key'],
                                                    'code' => $localityInput['federal_entity']['code']
                                                ]
                                            )->key;
            $locality->municipality_id = Municipality::firstOrCreate(
                                            [
                                                'name' => $localityInput['municipality']['name'],
                                            ],
                                            [
                                                'key' => $localityInput['municipality']['key']
                                            ]
                                        )->id;
            
            $locality->save();
            $this->info("Locality creada");        
        }
    
        foreach ($localityInput['settlements'] as $settlement) {
            $this->info("settlement:  " . $settlement['name']);

            $locality->settlements()->updateOrCreate(
                                        [
                                            'key' => $settlement['key'],
                                            'name' => $settlement['name'],
                                        ],
                                        [
                                            'zone_type' => $settlement['zone_type'],
                                            'settlement_type_id' => SettlementType::updateOrCreate(['name' => $settlement['settlement_type']['name']])->id
                                        ]
                                    );
        }
    
        $this->info("Settlemensts de Santiago de Queretaro agregados!");
        return 0;
    }
}
