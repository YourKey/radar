<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\Project;
use App\Models\Snapshot;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::factory(5)->create();
         Project::factory(10)->create();
         Page::factory(100)->create();
         Snapshot::factory(300)->create();
    }
}
