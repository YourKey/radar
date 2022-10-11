@extends('layouts.app')
@section('content')
    <div>
        <h1 class="mt-6 mb-3 card-title">
            <a class="link link-primary" href="{{ route('projects.show', $project) }}">{{ $project->name }}</a> → <a target="_blank" class="link link-primary" href="{{ $page->url }}">{{ urldecode($page->url) }}</a>
            <div class="badge">{{ $page->snapshots->count() }} snapshots</div>
        </h1>
    </div>
    @if ($diff['diff'] && $diff['diff'] !== 'No differences found')
    <div>
        <div class="grid grid-cols-2 bg-gray-300 mt-4">
            <div class="p-3">
                {{ $diff['old']->created_at->format('d.m.Y H:i:s') }}
            </div>
            <div class="p-3">
                {{ $diff['new']->created_at->format('d.m.Y H:i:s') }}
            </div>
        </div>
        {!! $diff['diff'] !!}
    </div>
    @elseif ($page->snapshots_count == 1)
        <div class="card-title mt-4 mb-2">Actual content</div>
        <div class="mockup-code mt-3 max-h-screen overflow-auto">
            <pre><code>{{ $diff['new']->data }}</code></pre>
        </div>
    @endif
    @if ($page->snapshots_count > 1)
        @if ($diff['diff'] == 'No differences found')
            <div class="alert alert-secondary">No differences found</div>
        @endif
        <div class="card-title mt-4 mb-2">Actual content</div>
        <div class="mockup-code mt-3 max-h-screen overflow-auto">
            <pre><code>{{ $diff['new']->data }}</code></pre>
        </div>
    @endif
    <div class="card bg-base-100 w-96 mt-6">
        <div class="card-body">
            <div class="card-title">Parser settings</div>
            <div>
                Parsing type: {{ $page->page_filters->type }}
            </div>
            <div>
                Selector: {{ $page->page_filters->selector ?? '–' }}
            </div>
            <div>
                Remove selector: {{ $page->page_filters->removeSelector ?? '–' }}
            </div>
        </div>
    </div>
@endsection
