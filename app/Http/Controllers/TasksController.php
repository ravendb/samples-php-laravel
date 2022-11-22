<?php

namespace App\Http\Controllers;

use App\Domain\Task\TaskFilter;
use App\Domain\Task\TaskGroupBy;
use App\Domain\Task\TaskSortBy;
use App\Services\TaskRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;
class TasksController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Show the profile for a given user.
     *
     * @param Request $request
     *
     * @return View
     */
    public function list(Request $request): View
    {
        $filterString = $request->input('filter', null);
        $filter = empty($filterString) ? TaskFilter::default() : new TaskFilter($filterString);

        $sortByString = $request->input('sortBy', null);
        $sortBy = empty($sortByString) ? TaskSortBy::default() : new TaskSortBy($sortByString);

        $groupByString = $request->input('groupBy', null);
        $groupBy = empty($groupByString) ? TaskGroupBy::default() : new TaskGroupBy($groupByString);


        $groups = $this->getTasks($filter, $groupBy, $sortBy);

        return view('tasks.list', [
            'groups' => $groups,
            'filter' => $filter,
            'groupBy' => $groupBy,
            'sortBy' => $sortBy,
            'queryParameters' => $request->all(),
        ]);
    }

    private function getTasks(TaskFilter $filter, mixed $groupBy, TaskSortBy $sortBy): array
    {
        if ($groupBy->isPriority()) {
            return $this->taskRepository->getTasksGroupByPriority($filter, $sortBy);
        }
        if ($groupBy->isDueDate()) {
            return $this->taskRepository->getTasksGroupByDueDate($filter, $sortBy);
        }
        if ($groupBy->isDateAdded()) {
            return $this->taskRepository->getTasksGroupByDateAdded($filter, $sortBy);
        }
        if ($groupBy->isDateCompleted()) {
            return $this->taskRepository->getTasksGroupByDateCompleted($filter, $sortBy);
        }
        return $this->taskRepository->getTasks($filter, $sortBy);
    }
}
