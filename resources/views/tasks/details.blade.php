<div class="d-flex border-bottom py-1 gap-3 align-items-center task-details">
    <div class="">
        @if ($task->isDone())
            <form action="{{ route('task.patch', ['id' => $task->getId()]) . '?' . http_build_query($queryParameters) }}"
                  method="post">
                <input type="hidden" name="action" value="uncheck_task">
                <button class="btn btn-none btn-complete p-2" type="submit">
                    <i class="bi bi-check-square p-2 text-success"></i>
                </button>
                @method('patch')
                @csrf
            </form>
        @else
            <form action="{{ route('task.patch', ['id' => $task->getId()]) . '?' . http_build_query($queryParameters) }}"
                  method="post">
                <input type="hidden" name="action" value="complete_task">
                <button class="btn btn-none btn-complete p-2" type="submit">
                    <i class="bi bi-square-fill p-2 priority-color-{{ $task->getPriority() }}"></i>
                </button>
                @method('patch')
                @csrf
            </form>
        @endif
    </div>
    <div @class(['flex-fill', 'text-muted' => $task->isDone()])>
        <div class="d-flex flex-row">
            <div @class(['row', 'align-middle', 'me-auto', 'text-muted' => $task->isDone()])>
                <div class="row">{{ $task->getName() }}</div>
                <div class="row small">{{ $task->getDescription() }}</div>
            </div>

            <div class="d-flex flex-row gap-1 me-2 task-actions align-items-center">
                <a href="#!"
                   class="p-2"
                   style="display: none"
                   data-bs-toggle="edit-tooltip"
                   data-bs-placement="top"
                   data-bs-title="This top tooltip is themed via CSS variables."
                   title="Edit task"><i class="bi bi-pen text-secondary"></i></a>
                <form action="{{ route('task.delete', ['id' => $task->getId()]) . '?' . http_build_query($queryParameters) }}"
                      method="post">
                    <button class="btn btn-none btn-remove p-2" type="submit">
                        <i class="bi bi-trash text-danger"></i>
                    </button>
                    @method('delete')
                    @csrf
                </form>
            </div>
        </div>
        <div>
            @if($task->getDueAt() !== null)
                <div @class(['text-danger' => $task->isOverdue() && !$task->isDone()]) >
                    Due at: <i class="bi bi-calendar"></i> {{$task->getDueAt()->format('d. M Y')}}
                </div>
            @endif
        </div>
    </div>
</div>
