<div @class(['mb-1', 'mt-4', 'd-flex', 'flex-row', 'align-middle'])>
    <strong>{{ $group->getName() }}</strong>
    <em @class(['ms-4'])>{{ count($group->getTasks()) }} {{  Str::plural('tasks', $group->getTasks()) }}</em>
</div>
<hr @class(['m-0', 'p-0'])/>

@foreach($group->getTasks() as $task)
    @include('tasks.details')
@endforeach
