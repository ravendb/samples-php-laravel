<?php

namespace App\Http\Controllers;

use App\Services\RavenDBManager;
use App\Services\TaskRepository;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use InvalidArgumentException;

class TaskController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private TaskRepository $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Delete the task
     *
     * @param Request $request
     * @param string|null $id
     *
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function delete(Request $request, ?string $id): RedirectResponse
    {
        $this->repository->deleteTask($id);

        return to_route('tasks', $request->query());
    }

    /**
     * Patch the task.
     *
     * @param Request $request
     * @param string $id
     * @param RavenDBManager $manager
     *
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function patch(Request $request, string $id, RavenDBManager $manager): RedirectResponse
    {

        switch (strtolower($request->action)) {
            case 'complete_task':
                $this->repository->completeTask($id);
                break;
            case 'uncheck_task':
                $this->repository->uncheckTask($id);
                break;
            default:
                throw new InvalidArgumentException('Invalid action: ' . $request->action . ' received.');
        }

        return to_route('tasks', $request->query());
    }


}
