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
    public function show(Project $project, Page $page): View
    {
        $page->load('snapshots')->loadCount('snapshots');

        $diff = (new DiffService())->diffSnapshots($page->snapshots);

        return view('projects.snapshots', compact('project', 'page', 'diff'));
    }
}
