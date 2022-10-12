<?php

namespace App\Console\Commands;

use App\Jobs\parseGuzzleJob;
use App\Models\Project;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;

class dispatchPageParser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'projects:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch pages to parser';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $projects = Project::where('status', 'active')
            ->with(['pages', 'pages.project'])
            ->get();
        foreach ($projects as $project) {
            foreach ($project->pages as $page) {
                dump(Carbon::now()->diffInHours($page->parsed_at), $page->canBeParsed(), $page->id);
                if (!$page->canBeParsed()) continue;
                parseGuzzleJob::dispatch($page);
            }
        }
    }
}
