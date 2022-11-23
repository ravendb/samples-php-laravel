<?php

namespace App\Console\Commands;

use App\Domain\Database\DatabaseSeeder;
use App\Services\RavenDBManager;
use Illuminate\Console\Command;

class SeedRavenDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ravendb:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed initial data to RavenDB';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param RavenDBManager $manager
     *
     * @return int
     */
    public function handle(RavenDBManager $manager): int
    {
        $manager->removeDatabaseIfExists();
        $manager->createDatabase();

        $seeder = new DatabaseSeeder($manager);
        $seeder->seed();

        return parent::SUCCESS;
    }
}
