<?php

namespace App\Domain\Task\Index;

use App\Domain\Task\TaskArray;

class TaskByPriorityResult
{
    private int $priority;
    private ?TaskArray $tasks = null;

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(mixed $priority): void
    {
        $this->priority = intval($priority);
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
