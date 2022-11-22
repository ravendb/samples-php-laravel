<?php

namespace App\Domain\Task\Index;

use App\Domain\Task\TaskArray;

class TaskByDateCompletedResult
{
    private ?string $completedAt = null;
    private ?TaskArray $tasks = null;

    public function getCompletedAt(): ?string
    {
        return $this->completedAt;
    }

    public function setCompletedAt(mixed $completedAt): void
    {
        $this->completedAt = $completedAt;
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
