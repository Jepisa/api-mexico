<?php

namespace App\Console\Commands;

use App\Imports\LocalitiesImport;
use Illuminate\Console\Command;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class runImportLacalities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'locality:import {--p|path=public/excels/CPdescarga.xls : Este es el path donde está el archivo excel (dentro de storage/app) }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando sirve para importar las localidades desde un excel';

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
        ini_set('max_execution_time', -1);
        ini_set('memory_limit', '-1');
        $pathExcel = $this->option('path');
        if (Storage::disk('local')->exists($pathExcel)) {
            $this->info('Inicio de la importacion: ' . date('Y-m-d H:i:s'));
            $this->info("Comenzó la importación!");
            Excel::import(new LocalitiesImport(1, 32), storage_path("app/$pathExcel"));
            $this->info("Terminó importación!");

        } else {
            return $this->error("No se encontró el archivo '$pathExcel'");
        }
        
        $this->info('Finalización de la importacion: ' . date('Y-m-d H:i:s'));
        return 0;
    }
}
