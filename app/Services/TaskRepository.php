<?php

namespace App\Services;

use App\Domain\Task\Index\TaskByDateAddedResult;
use App\Domain\Task\Index\TaskByDateCompletedResult;
use App\Domain\Task\Index\TaskByDueDateResult;
use App\Domain\Task\Index\TaskByPriorityResult;
use App\Domain\Task\Task;
use App\Domain\Task\TaskArray;
use App\Domain\Task\TaskFilter;
use App\Domain\Task\TaskGroup;
use App\Domain\Task\TaskSortBy;
use DateTime;
use RavenDB\Documents\Session\OrderingType;
use Throwable;

class TaskRepository
{
    private RavenDBManager $manager;

    public function __construct(RavenDBManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return array<Task>
     */
    public function getTasks(TaskFilter $filter, TaskSortBy $sortBy): array
    {
        $store = $this->manager->getStore();

        $session = $store->openSession();
        try {

            $query = $session
                ->query(Task::class);

            if (!$filter->isAll()) {
                $query->whereEquals('done', $filter->isCompleted());
            }

            $sortField = $this->getFieldNameForOrdering($sortBy);
            if (!empty($sortField)) {
                $query->orderBy($sortField);
            }

            $tasks = $query->orderBy('done', OrderingType::alphaNumeric())
                ->orderBy('name', OrderingType::alphaNumeric())
                ->toList();

        } finally {
            $session->close();
        }

        $taskGroups = [];

        $taskGroup = new TaskGroup();
        $taskGroup->setName('Sort by ' . ucfirst($sortBy->getValue()) . ' ');
        $taskGroup->setTasks(TaskArray::fromArray($tasks));

        $taskGroups[] = $taskGroup;

        return $taskGroups;
    }

    private function getFieldNameForOrdering(TaskSortBy $sortBy): ?string
    {
        if ($sortBy->isAlphabetical()) {
            return 'name';
        }
        if ($sortBy->isDueDate()) {
            return 'dueAt';
        }
        if ($sortBy->isDateCompleted()) {
            return 'completedAt';
        }
        if ($sortBy->isDateAdded()) {
            return 'createdAt';
        }
        if ($sortBy->isPriority()) {
            return 'priority';
        }
        return null;
    }

    /**
     * @return array<TaskGroup>
     */
    public function getTasksGroupByPriority(TaskFilter $filter, TaskSortBy $sortBy): array
    {
        $store = $this->manager->getStore();

        $session = $store->openSession();
        try {
            $rql = 'from index \'TaskByPriorityIndex\' as list ';
            $rql .= 'order by list.priority asc ';
            $rql .= 'select {
                        priority: list.priority
                        tasks: ';
            $rql .= 'list.tasks';

            $rql .= $this->tasksFilteringAndSortingRql($filter, $sortBy);

            $rql .= '}';

            $groups = $session->advanced()
                ->rawQuery(TaskByPriorityResult::class, $rql)
                ->toList();
        } finally {
            $session->close();
        }

        $taskGroups = [];
        foreach ($groups as $group) {
            $taskGroup = new TaskGroup();
            $taskGroup->setName('Priority ' . intval($group->getPriority()));
            $taskGroup->setTasks($group->getTasks());

            $taskGroups[] = $taskGroup;
        }

        return $taskGroups;
    }

    private function tasksFilteringAndSortingRql(TaskFilter $filter, TaskSortBy $sortBy): string
    {
        $rql = '';

        if (!$filter->isAll()) {
            $completed = $filter->isCompleted() ? 'true' : 'false';
            $rql .= '.filter(x => x.done === ' . $completed . ')';
        }

        if ($sortBy->isAlphabetical()) {
            $rql .= '.sort((a, b) => a.name < b.name ? -1 : 1)'; // sort by name asc
        } elseif ($sortBy->isDueDate()) {
            $rql .= '.map(x => { x.sortField = x.dueAt === null ? \'5000-01-01\' : x.dueAt; return x;})'; // push the null dates to the end
            $rql .= '.sort((a, b) => a.sortField < b.sortField ? -1 : 1)'; // sort by due date asc
        } elseif ($sortBy->isDateAdded()) {
            $rql .= '.sort((a, b) => a.createdAt < b.createdAt ? -1 : 1)'; // sort by createdAt asc
        } elseif ($sortBy->isPriority()) {
            $rql .= '.sort((a, b) => a.priority < b.priority ? -1 : 1)'; // sort by createdAt asc
        }

        return $rql;
    }

    /**
     * @return array<TaskGroup>
     */
    public function getTasksGroupByDueDate(TaskFilter $filter, TaskSortBy $sortBy): array
    {
        $store = $this->manager->getStore();

        $session = $store->openSession();
        try {
            $rql = 'from index \'TaskByDueDateIndex\' as list ';
            $rql .= 'order by list.dueAt asc ';
            $rql .= 'select {
                        dueAt: list.dueAt
                        tasks: ';
            $rql .= 'list.tasks';

            $rql .= $this->tasksFilteringAndSortingRql($filter, $sortBy);

            $rql .= '}';

            $groups = $session->advanced()
                ->rawQuery(TaskByDueDateResult::class, $rql)
                ->toList();
        } finally {
            $session->close();
        }

        $taskGroups = [];
        foreach ($groups as $group) {
            if (!$group->getTasks()->count()) {
                continue;
            }

            $taskGroup = new TaskGroup();
            $taskGroup->setName(empty($group->getDueAt()) ? 'Due date not set' : 'Due at: ' . $this->formatDate($group->getDueAt()));
            $taskGroup->setTasks($group->getTasks());

            $taskGroups[] = $taskGroup;
        }

        return $taskGroups;
    }

    /**
     * @return array<TaskGroup>
     */
    public function getTasksGroupByDateAdded(TaskFilter $filter, TaskSortBy $sortBy): array
    {
        $store = $this->manager->getStore();

        $session = $store->openSession();
        try {
            $rql = 'from index \'TaskByDateAddedIndex\' as list ';
            $rql .= 'order by list.createdAt asc ';
            $rql .= 'select {
                        createdAt: list.createdAt
                        tasks: ';
            $rql .= 'list.tasks';

            $rql .= $this->tasksFilteringAndSortingRql($filter, $sortBy);

            $rql .= '}';

            $groups = $session->advanced()
                ->rawQuery(TaskByDateAddedResult::class, $rql)
                ->toList();
        } finally {
            $session->close();
        }

        $taskGroups = [];
        foreach ($groups as $group) {
            if (!$group->getTasks()->count()) {
                continue;
            }

            $taskGroup = new TaskGroup();
            $taskGroup->setName('Created at: ' . $this->formatDate($group->getCreatedAt()));
            $taskGroup->setTasks($group->getTasks());

            $taskGroups[] = $taskGroup;
        }

        return $taskGroups;
    }

    /**
     * @return array<TaskGroup>
     */
    public function getTasksGroupByDateCompleted(TaskFilter $filter, TaskSortBy $sortBy): array
    {
        $store = $this->manager->getStore();

        $session = $store->openSession();
        try {
            $rql = 'from index \'TaskByDateCompletedIndex\' as list ';
            $rql .= 'order by list.completedAt asc ';
            $rql .= 'select {
                        completedAt: list.completedAt
                        tasks: ';
            $rql .= 'list.tasks';

            $rql .= $this->tasksFilteringAndSortingRql($filter, $sortBy);

            $rql .= '}';

            $groups = $session->advanced()
                ->rawQuery(TaskByDateCompletedResult::class, $rql)
                ->toList();
        } finally {
            $session->close();
        }

        $taskGroups = [];
        foreach ($groups as $group) {
            if (!$group->getTasks()->count()) {
                continue;
            }

            $taskGroup = new TaskGroup();
            $taskGroup->setName($group->getCompletedAt() ? 'Completed at: ' . $this->formatDate($group->getCompletedAt()) : 'Opened tasks');
            $taskGroup->setTasks($group->getTasks());

            $taskGroups[] = $taskGroup;
        }

        return $taskGroups;
    }


    public function deleteTask(?string $id): void
    {
        $store = $this->manager->getStore();

        $session = $store->openSession();
        try {
            $session->delete($id);
            $session->saveChanges();
        } catch (Throwable $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        } finally {
            $session->close();
        }
    }

    public function completeTask(?string $id): void
    {
        $store = $this->manager->getStore();

        $session = $store->openSession();
        try {
            /** @var Task $task */
            $task = $session->load(Task::class, $id);
            $task->setDone(true);
            $task->setCompletedAt(new DateTime());
            $session->saveChanges();
        } catch (Throwable $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        } finally {
            $session->close();
        }
    }

    public function uncheckTask(?string $id): void
    {
        $store = $this->manager->getStore();

        $session = $store->openSession();
        try {
            /** @var Task $task */
            $task = $session->load(Task::class, $id);
            $task->setDone(false);
            $task->setCompletedAt(null);
            $session->saveChanges();
        } catch (Throwable $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        } finally {
            $session->close();
        }

    }

    private function formatDate($date): string
    {
        return (new DateTime($date))->format('d. M Y');
    }
}
