<?php

namespace App\Domain\Task\Index;

use App\Domain\Task\TaskArray;

class TaskByDueDateResult
{
    private ?string $dueAt = null;
    private ?TaskArray $tasks = null;

    public function getDueAt(): ?string
    {
        return $this->dueAt;
    }

    public function setDueAt(mixed $dueAt): void
    {
        $this->dueAt = $dueAt;
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
