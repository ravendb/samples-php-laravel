<?php

namespace App\Domain\Task;

class TaskSortBy
{
    private const ALPHABETICAL = 'alphabetical';
    private const DUE_DATE = 'due date';
    private const DATE_ADDED = 'date added';
    private const DATE_COMPLETED = 'date completed';
    private const PRIORITY = 'priority';

    private const DEFAULT = self::DATE_ADDED;

    private string $value = self::DEFAULT;

    public function __construct(?string $value)
    {
        $this->value = strtolower($value) ?? self::DEFAULT;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isAlphabetical(): bool
    {
        return $this->value == self::ALPHABETICAL;
    }

    public function isDueDate(): bool
    {
        return $this->value == self::DUE_DATE;
    }

    public function isDateAdded(): bool
    {
        return $this->value == self::DATE_ADDED;
    }

    public function isDateCompleted(): bool
    {
        return $this->value == self::DATE_COMPLETED;
    }

    public function isPriority(): bool
    {
        return $this->value == self::PRIORITY;
    }

    public static function default(): TaskSortBy
    {
        return new TaskSortBy(self::DEFAULT);
    }
}
