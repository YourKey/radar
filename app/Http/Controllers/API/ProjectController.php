<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectWithPagesRequest;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{

    public function store(ProjectWithPagesRequest $request): Project
    {
        return (new ProjectService())->storeProjectWithPages($request);
    }
}
