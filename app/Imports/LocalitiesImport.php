<?php

namespace App\Imports;

use App\Models\Locality;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;

class LocalitiesImport implements WithMultipleSheets, SkipsUnknownSheets
{
    public function sheets(): array
    {
        $arraySheet = [];
        for ($i=1; $i <= 32; $i++) { 
            $arraySheet[$i] = new LocalitySheetImport();
        }

        return $arraySheet;
    }

    public function onUnknownSheet($sheetName)
    {
        // E.g. you can log that a sheet was not found.
        info("Sheet {$sheetName} was skipped");
    }
}
