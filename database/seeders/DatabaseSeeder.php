<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\Project;
use App\Models\Snapshot;
use App\Models\User;
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
         User::factory(5)->create();
         User::factory()->create(['name' => 'demo', 'email' => 'demo@demo.com']);
         Project::factory(10)->create();
         Page::factory(100)->create();
         Snapshot::factory(300)->create();
    }
}
