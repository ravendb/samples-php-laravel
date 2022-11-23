<?php

namespace App\Domain\Database;

use App\Domain\Task\Index\TaskByDateAddedIndex;
use App\Domain\Task\Index\TaskByDateCompletedIndex;
use App\Domain\Task\Index\TaskByDueDateIndex;
use App\Domain\Task\Index\TaskByPriorityIndex;
use App\Domain\Task\Task;
use App\Services\RavenDBManager;
use RavenDB\Documents\DocumentStore;

use Faker;

class DatabaseSeeder
{
    private RavenDBManager $manager;
    private Faker\Generator $faker;

    public function __construct(RavenDBManager $manager)
    {
        $this->manager = $manager;

        $this->faker = Faker\Factory::create();
    }

    public function seed(?string $database = null): void
    {
        $store = $this->manager->getStore($database);

        $this->createTasks($store, 100);

        $store->executeIndex(new TaskByPriorityIndex());
        $store->executeIndex(new TaskByDueDateIndex());
        $store->executeIndex(new TaskByDateAddedIndex());
        $store->executeIndex(new TaskByDateCompletedIndex());
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
