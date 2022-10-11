@extends('layouts.app')
@section('content')
    <h1 class="mt-6 mb-3 card-title">
        {{ $project->name }}
        <div class="badge">{{ $project->pages->count() }} urls</div>
    </h1>
    @foreach($project->pages as $page)
        <page-card :page="{{ $page->append('snapshots_url') }}"></page-card>
    @endforeach
@endsection
