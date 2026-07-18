<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallOracleSchema extends Command
{
    protected $signature = 'oracle:install-schema';

    protected $description = 'Print SQL*Plus commands to install AmarMart Oracle schema and PL/SQL';

    public function handle(): int
    {
        $base = base_path('database/oracle');

        $this->info('Run these commands in Terminal (with sqlplus on PATH):');
        $this->line('sqlplus amarmart/AmarMart123@localhost:1521/XE @'.$base.DIRECTORY_SEPARATOR.'01_schema.sql');
        $this->line('sqlplus amarmart/AmarMart123@localhost:1521/XE @'.$base.DIRECTORY_SEPARATOR.'02_plsql.sql');

        return self::SUCCESS;
    }
}
