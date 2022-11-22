<?php

namespace App\Console\Commands;

use App\Domain\Task\Index\TaskByDateAddedIndex;
use App\Domain\Task\Index\TaskByDateCompletedIndex;
use App\Domain\Task\Index\TaskByDueDateIndex;
use App\Domain\Task\Index\TaskByPriorityIndex;
use App\Domain\Task\Task;
use App\Services\RavenDBManager;
use Illuminate\Console\Command;

use RavenDB\Documents\DocumentStore;

use Faker;

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

    private Faker\Generator $faker;

    public function __construct()
    {
        parent::__construct();

        $this->faker = Faker\Factory::create();
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
        try {
            $manager->removeDatabaseIfExists();
            $manager->createDatabase();
            $store = $manager->getStore();

            $this->createTasks($store, 100);

            $store->executeIndex(new TaskByPriorityIndex());
            $store->executeIndex(new TaskByDueDateIndex());
            $store->executeIndex(new TaskByDateAddedIndex());
            $store->executeIndex(new TaskByDateCompletedIndex());

        } catch (\Throwable $e) {
            $next = $e;
            echo PHP_EOL . PHP_EOL;
            while ($next!= null) {
                echo '>>>' . $next->getMessage() . PHP_EOL. PHP_EOL;
                $next = $next->getPrevious();
            }
        }

        return parent::SUCCESS;
    }

    private function createTasks(DocumentStore $store, int $count = 50)
    {
        $session = $store->openSession();
        try {
            for ($i = 0; $i < $count; $i++) {
                $session->store($this->createTask());
            }
            $session->saveChanges();

        } finally {
            $session->close();
        }
    }

    private function createTask(): Task
    {
        $task = new Task();
        $task->setName($this->faker->text(rand(15, 30)));
        $task->setDescription($this->faker->text(rand(40, 80)));

        $task->setPriority(rand(1, 4));

        $createdAt = $this->faker->dateTimeBetween('-6 weeks', 'now');
        $task->setCreatedAt($createdAt);

        $completedAt = rand(0, 4) ? null : $this->faker->dateTimeBetween($createdAt, 'now');
        $task->setCompletedAt($completedAt);
        $task->setDone($completedAt !== null);

        $dueAt = rand(0, 1) ? null : $this->faker->dateTimeBetween($createdAt, '+2 months');
        $task->setDueAt($dueAt);

        return $task;
    }
}
