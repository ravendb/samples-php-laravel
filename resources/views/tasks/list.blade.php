@extends('layouts.app')

@section('content')

    <div @class(['mb-3', 'd-flex', 'flex-row', 'align-middle'])>
        <div class="btn-group btn-group-sm me-auto" role="group" aria-label="Small button group">
            <a href="{{ route('tasks') . '?' . http_build_query(array_merge($queryParameters, ['filter'=>'all'])) }}" type="button" @class(['btn','btn-outline-dark', 'active' => $filter->isAll()])>All</a>
            <a href="{{ route('tasks') . '?' . http_build_query(array_merge($queryParameters, ['filter'=>'opened'])) }}" type="button" @class(['btn','btn-outline-dark', 'active' => $filter->isOpened()])>Opened</a>
            <a href="{{ route('tasks') . '?' . http_build_query(array_merge($queryParameters, ['filter'=>'completed'])) }}" type="button" @class(['btn','btn-outline-dark', 'active' => $filter->isCompleted()])>Completed</a>
        </div>
        <div class="ms-3">
            <span>Group by</span>
            <div class="btn-group ms-1">
                <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ ucfirst($groupBy->getValue()) }}
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('tasks') . '?' . http_build_query(array_merge($queryParameters, ['groupBy'=>'None'])) }}">@if($groupBy->isNone())<i class="bi bi-check"></i>@endif None</a></li>
                    <li><a class="dropdown-item" href="{{ route('tasks') . '?' . http_build_query(array_merge($queryParameters, ['groupBy'=>'Due date'])) }}">@if($groupBy->isDueDate())<i class="bi bi-check"></i>@endif Due date</a></li>
                    <li><a class="dropdown-item" href="{{ route('tasks') . '?' . http_build_query(array_merge($queryParameters, ['groupBy'=>'Date added'])) }}">@if($groupBy->isDateAdded())<i class="bi bi-check"></i>@endif Date added</a></li>
                    <li><a class="dropdown-item" href="{{ route('tasks') . '?' . http_build_query(array_merge($queryParameters, ['groupBy'=>'Date completed'])) }}">@if($groupBy->isDateCompleted())<i class="bi bi-check"></i>@endif Date completed</a></li>
                    <li><a class="dropdown-item" href="{{ route('tasks') . '?' . http_build_query(array_merge($queryParameters, ['groupBy'=>'priority'])) }}">@if($groupBy->isPriority())<i class="bi bi-check"></i>@endif Priority</a></li>
                </ul>
            </div>
        </div>
        <div class="ms-3">
            <span>Sort by</span>
            <div class="btn-group ms-1">
                <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ ucfirst($sortBy->getValue()) }}
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('tasks') . '?' . http_build_query(array_merge($queryParameters, ['sortBy'=>'Alphabetical'])) }}">@if($sortBy->isAlphabetical())<i class="bi bi-check"></i>@endif Alphabetical</a></li>
                    <li><a class="dropdown-item" href="{{ route('tasks') . '?' . http_build_query(array_merge($queryParameters, ['sortBy'=>'Due date'])) }}">@if($sortBy->isDueDate())<i class="bi bi-check"></i>@endif Due date</a></li>
                    <li><a class="dropdown-item" href="{{ route('tasks') . '?' . http_build_query(array_merge($queryParameters, ['sortBy'=>'Date added'])) }}">@if($sortBy->isDateAdded())<i class="bi bi-check"></i>@endif Date added</a></li>
                    <li><a class="dropdown-item" href="{{ route('tasks') . '?' . http_build_query(array_merge($queryParameters, ['sortBy'=>'Date completed'])) }}">@if($sortBy->isDateCompleted())<i class="bi bi-check"></i>@endif Date completed</a></li>
                    <li><a class="dropdown-item" href="{{ route('tasks') . '?' . http_build_query(array_merge($queryParameters, ['sortBy'=>'Priority'])) }}">@if($sortBy->isPriority())<i class="bi bi-check"></i>@endif Priority</a></li>
                </ul>
            </div>
        </div>
    </div>

    <hr @class(['m-0', 'p-0'])/>
    @foreach($groups as $group)
        @include('tasks.groupDetails')
    @endforeach
@endsection
