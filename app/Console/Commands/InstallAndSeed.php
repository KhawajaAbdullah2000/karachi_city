<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InstallAndSeed extends Command
{
    protected $signature = 'install:seed';
    protected $description = 'Run composer install, composer update, migrate:fresh, and db:seed';

    public function handle()
    {
        $this->info('Running composer install...');
        exec('composer install');

        $this->info('Running composer update...');
        exec('composer update');

        $this->info('Running migrate:fresh...');
        Artisan::call('migrate:fresh');

        $this->info('Running db:seed...');
        Artisan::call('db:seed');

        $this->info('Installation and seeding completed.');
    }
}
