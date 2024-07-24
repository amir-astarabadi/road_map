<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Modules\RoadMap\Database\Seeders\CareerSeeder;
use Modules\RoadMap\Database\Seeders\QuestionSeeder;
use Modules\Authentication\Database\Seeders\RoleSeeder;

class Deploy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'deplyment plan';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Artisan::call('migrate');
        Artisan::call('db:seed', ['--class' => CareerSeeder::class]);
        Artisan::call('db:seed', ['--class' => QuestionSeeder::class]);
        Artisan::call('db:seed', ['--class' => RoleSeeder::class]);
    }
}
