<?php

namespace App\Domain\Task;

use DateTime;
use DateTimeInterface;

class Task
{
    private ?string $id = null;
    private ?string $name = null;
    private ?string $description = null;
    private bool $done = false;
    private ?DateTimeInterface $dueAt = null;
    private ?DateTimeInterface $createdAt = null;
    private ?DateTimeInterface $completedAt = null;
    private int $priority;

    public function __construct()
    {
        $this->priority = 4;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function isDone(): bool
    {
        return $this->done;
    }

    public function setDone(bool $done): void
    {
        $this->done = $done;
    }

    public function getDueAt(): ?DateTimeInterface
    {
        return $this->dueAt;
    }

    public function setDueAt(?DateTimeInterface $dueAt): void
    {
        $this->dueAt = $dueAt;
    }

    public function isOverdue(): bool
    {
        if ($this->dueAt == null) {
            return false;
        }

        $now = new DateTime();

        return $this->dueAt < $now;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCompletedAt(): ?DateTimeInterface
    {
        return $this->completedAt;
    }

    public function setCompletedAt(?DateTimeInterface $completedAt): void
    {
        $this->completedAt = $completedAt;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }
}
