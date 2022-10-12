<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Project;
use App\Services\DiffService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Jfcherng\Diff\DiffHelper;
use Jfcherng\Diff\Renderer\RendererConstant;

class PageController extends Controller
{
    public function show(Project $project, Page $page, DiffService $diff_service): View
    {
        $page->load('snapshots')->loadCount('snapshots');

        $diff = $diff_service->diffSnapshots($page->snapshots);

        return view('projects.snapshots', compact('project', 'page', 'diff'));
    }
}
