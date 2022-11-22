<?php

namespace App\Console\Commands;

use App\Services\RavenDBManager;
use Illuminate\Console\Command;

class RemoveRavenDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ravendb:remove';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove database from server.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(RavenDBManager $manager)
    {
        $manager->removeDatabaseIfExists();

        return Command::SUCCESS;
    }
}
