<?php

namespace App\Imports;

use App\Models\FederalEntity;
use App\Models\Locality;
use App\Models\Municipality;
use App\Models\SettlementType;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class LocalitySheetImport implements ToCollection
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        $nro_de_filas = 0;
        foreach ($rows as $key => $row) {
            if ($key == 0) continue;
            $nro_de_filas++;
            $this->createLocatity($row);
        }
        info("Temino Sheet");
        info("Cantidad de filas: $nro_de_filas");
    }

    public function createLocatity($row)
    {
        foreach ($row as $key => $field) {
            if(isset($field) and is_string($field) and $key != 2){
                $field = $this->eliminar_acentos($field);
                $row[$key] = strtoupper($field);
            }
        }

        $locality = Locality::firstWhere('zip_code', $row[0]);

        if(!$locality) {

            $locality = new Locality;
            $locality->zip_code = $row[0];
            $locality->locality = !isset($row[5]) ? '' : $row[5];
            $locality->federal_entity_id = FederalEntity::updateOrCreate(
                                                [
                                                    'name' => $row[4],
                                                ],
                                                [
                                                    'key' => $row[7],
                                                    'code' => $row[9]
                                                ]
                                            )->key;
            $locality->municipality_id = Municipality::updateOrCreate(
                                                [
                                                    'name' => $row[3]
                                                ], 
                                                [
                                                    'key' => $row[11]
                                                ]
                                            )->id;
                                            
            $locality->save();
        }

        
        $locality->settlements()->updateOrCreate(
            [
                'key' => $row[12], //0345  //0345
                'name' => $row[1], //Villas de Don Antonio  //Panamericano
            ],
            [
                'zone_type' => $row[13], 
                'settlement_type_id' => SettlementType::updateOrCreate(['name' => $row[2]])->id
            ]
        );
        
    }

    function eliminar_acentos($cadena){
		
		//Reemplazamos la A y a
		$cadena = str_replace(
		array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
		array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
		$cadena
		);

		//Reemplazamos la E y e
		$cadena = str_replace(
		array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
		array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
		$cadena );

		//Reemplazamos la I y i
		$cadena = str_replace(
		array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
		array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
		$cadena );

		//Reemplazamos la O y o
		$cadena = str_replace(
		array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
		array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
		$cadena );

		//Reemplazamos la U y u
		$cadena = str_replace(
		array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
		array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
		$cadena );

		//Reemplazamos la N, n, C y c
		$cadena = str_replace(
		array('Ñ', 'ñ', 'Ç', 'ç'),
		array('N', 'n', 'C', 'c'),
		$cadena
		);
		
		return $cadena;
	}
}
