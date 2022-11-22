<?php

namespace App\Domain\Task;

class TaskFilter
{
    private const ALL = 'all';
    private const OPENED = 'opened';
    private const COMPLETED = 'completed';
    private const DEFAULT = self::ALL;

    private string $value = self::DEFAULT;

    public function __construct(?string $value = null)
    {
        $this->value = $value ?? self::DEFAULT;
    }

    public function isAll(): bool
    {
        return $this->value == self::ALL;
    }

    public function isOpened(): bool
    {
        return $this->value == self::OPENED;
    }

    public function isCompleted(): bool
    {
        return $this->value == self::COMPLETED;
    }

    public static function default(): TaskFilter
    {
        return new TaskFilter();
    }
}
