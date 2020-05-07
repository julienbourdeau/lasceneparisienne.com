<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportDatabaseCommand extends Command
{
    protected $signature = 'db:import {name}';

    protected $description = 'Import sql file from `resources/{name}.sql` into your db';

    public function handle()
    {
        $file = resource_path("{$this->argument('name')}.sql");
        $this->line("Loading $file file...");

        $content = file_get_contents($file);
        DB::unprepared($content);

        $this->info('Done!');
    }
}
