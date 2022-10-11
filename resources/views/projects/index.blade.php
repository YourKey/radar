@extends('layouts.app')

@section('content')
    <div class="overflow-x-auto">
        <div class="mb-4">
            <a href="{{ route('projects.create') }}" class="btn">Create project</a>
        </div>
        @if(count($projects))
        <table class="table w-full">
            <!-- head -->
            <thead>
            <tr>
                <th>ID</th>
                <th>Project</th>
            </tr>
            </thead>
            <tbody>
            @foreach($projects as $project)
                <tr>
                    <th>{{ $project->id }}</th>
                    <td>
                        <a class="link link-primary" href="{{ route('projects.show', $project) }}">{{ $project->name }}</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @else
            <div class="alert shadow-lg">
                There's nothing here yet. Create your first project.
            </div>
        @endif
    </div>
@endsection
