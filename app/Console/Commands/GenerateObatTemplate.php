<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ObatExportTemplate;

class GenerateObatTemplate extends Command
{
    protected $signature = 'generate:template-obat';
    protected $description = 'Generate template Excel untuk import obat';

    public function handle()
    {
        Excel::store(new ObatExportTemplate, 'template/template_import_obat.xlsx', 'public');
        $this->info('Template berhasil dibuat di public/template/template_import_obat.xlsx');
    }
}