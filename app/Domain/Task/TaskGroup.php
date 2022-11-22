<?php

namespace App\Domain\Task;

class TaskGroup
{
    private ?string $name = null;
    private ?TaskArray $tasks = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
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
