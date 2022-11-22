<?php

namespace App\Domain\Task\Index;

use App\Domain\Task\TaskArray;

class TaskByDateAddedResult
{
    private ?string $createdAt = null;
    private ?TaskArray $tasks = null;

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(mixed $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getTasks(): ?TaskArray
    {
        return $this->tasks;
    }

    public function setTasks(?TaskArray $tasks): void
    {
        $this->tasks = $tasks;
    }
}
