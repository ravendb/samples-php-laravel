<div class="d-flex border-bottom py-0 gap-3 align-items-center task-details">
    <div class="">
        @if ($task->isDone())
            <form
                action="{{ route('task.patch', ['id' => $task->getId()]) . '?' . http_build_query($queryParameters) }}"
                method="post">
                <input type="hidden" name="action" value="uncheck_task">
                <button class="btn btn-none btn-complete p-2" type="submit">
                    <i class="bi bi-check-square p-2 text-success"></i>
                </button>
                @method('patch')
                @csrf
            </form>
        @else
            <form
                action="{{ route('task.patch', ['id' => $task->getId()]) . '?' . http_build_query($queryParameters) }}"
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
        <div @class(['d-flex', 'flex-row', 'align-items-center', 'text-muted' => $task->isDone()])>
                @if($task->getDueAt() !== null)
                    <span @class(['me-2', 'badge', 'bg-secondary', 'bg-danger' => $task->isOverdue() && !$task->isDone()])>{{$task->getDueAt()->format('d. M Y')}}</span>
                @endif
                <div class="col me-auto">{{ $task->getName() }}</div>

            <div class="small">{{ $task->getDescription() }}</div>

            <div class="d-flex flex-row gap-1 task-actions align-items-center">
                <a href="#!"
                   style="display: none"
                   data-bs-toggle="edit-tooltip"
                   data-bs-placement="top"
                   data-bs-title="This top tooltip is themed via CSS variables."
                   title="Edit task"><i class="bi bi-pen text-secondary"></i></a>
                <form
                    action="{{ route('task.delete', ['id' => $task->getId()]) . '?' . http_build_query($queryParameters) }}"
                    method="post">
                    <button class="btn btn-none btn-remove p-1 px-3" type="submit">
                        <i class="bi bi-trash text-danger"></i>
                    </button>
                    @method('delete')
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
