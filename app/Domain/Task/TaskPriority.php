<?php

namespace App\Domain\Task;

class TaskPriority
{
    private const PRIORITY_ONE = 1;
    private const PRIORITY_TWO = 2;
    private const PRIORITY_THREE = 3;
    private const PRIORITY_FOUR = 4;

    private const DEFAULT = self::PRIORITY_ONE;

    private int $value;

    public function __construct($priority = null)
    {
        $this->value = $priority == null ? self::DEFAULT : $priority;
    }

    public function getValue(): int
    {
        echo '>> priority: ' . $this->value . PHP_EOL;
        return $this->value;
    }

    public static function default(): TaskPriority
    {
        return new TaskPriority(self::DEFAULT);
    }

    public static function priorityOne(): TaskPriority
    {
        return new TaskPriority(self::PRIORITY_ONE);
    }

    public function isPriorityOne(): bool
    {
        return $this->value == self::PRIORITY_ONE;
    }

    public static function priorityTwo(): TaskPriority
    {
        return new TaskPriority(self::PRIORITY_TWO);
    }

    public function isPriorityTwo(): bool
    {
        return $this->value == self::PRIORITY_TWO;
    }

    public static function priorityThree(): TaskPriority
    {
        return new TaskPriority(self::PRIORITY_THREE);
    }

    public function isPriorityThree(): bool
    {
        return $this->value == self::PRIORITY_THREE;
    }

    public static function priorityFour(): TaskPriority
    {
        return new TaskPriority(self::PRIORITY_FOUR);
    }

    public function isPriorityFour(): bool
    {
        return $this->value == self::PRIORITY_FOUR;
    }
}
