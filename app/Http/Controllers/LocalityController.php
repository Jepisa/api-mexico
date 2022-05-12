<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\LocalitiesImport;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Locality;

class LocalityController extends Controller
{
    public function show($zip_code)
    {
        $locality = Cache::rememberForever("locality-$zip_code", function () use ($zip_code) {
            return Locality::where('zip_code', $zip_code)
                ->with([
                    'federal_entity:key,name,code',
                    'settlements',
                    'settlements.settlement_type:id,name',
                    'municipality:id,key,name'
                ])->firstOrFail();
        });

        return response()->json($locality);
    }

    public function saveLocalitiesInCache()
    {
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '-1');

        $locality_zip_codes = Locality::all('zip_code')->pluck('zip_code');

        $q_localities = 0;
        foreach ($locality_zip_codes as $zip_code) {
            Cache::rememberForever("locality-$zip_code", function () use ($zip_code) {
                return Locality::where('zip_code', $zip_code)
                    ->with([
                        'federal_entity:key,name,code',
                        'settlements',
                        'settlements.settlement_type:id,name',
                        'municipality:id,key,name'
                    ])->first();
            });
            $q_localities++;
        }

        return response()->json("Listo! - $q_localities Localidades");
    }

    public function importLocalities()
    {
        ini_set('max_execution_time', 300*4);
        ini_set('memory_limit', '-1');
        Excel::import(new LocalitiesImport, storage_path('app/excels/CPdescarga.xls'));

        return "Listo! Se importó!";
    }
}
