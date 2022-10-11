<?php
namespace App\Services;
use App\Http\Requests\ProjectWithPagesRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectService {
    public function storeProjectWithPages(ProjectWithPagesRequest $request): Project
    {
        return DB::transaction(function() use ($request) {
            $project = new Project();
            $project->name = $request->name;
            $project->user_id = $request->user()->id;
            $project->settings = $request->settings;
            $project->save();
            $project->pages()->createMany($request->pages);
            $project->redirect = route('projects.show', $project);
            return $project;
        });
    }
}
