<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::query()
            ->where('user_id', auth()->user()->id)
            ->orderByDesc('created_at')
            ->get();

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        $project->load(['pages', 'pages.snapshots', 'pages.project']);
        return view('projects.show', compact('project'));
    }

    public function create(): View
    {
        return view('projects.create');
    }
}
