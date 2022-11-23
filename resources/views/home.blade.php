@extends('layouts.app')

@section('content')

    <div @class(['text-center', 'mt-5'])>
        <div @class(['mb-5'])>
            Create database and seed initial data to RavenDB.
        </div>

        <a @class(['btn', 'btn-primary']) href="{{ route('seed') }}">Create & Seed</a>
    </div>

@endsection
