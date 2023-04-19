<?php

namespace App\Domain\Task;

use RavenDB\Type\TypedArray;

class TaskArray extends TypedArray
{
    public function __construct()
    {
        parent::__construct(Task::class);
    }

    public static function fromArray(array $data, bool $nullAllowed = false): static
    {
        $sa = new TaskArray();

        foreach ($data as $key => $value) {
            $sa->offsetSet($key, $value);
        }

        return $sa;
    }
}
