<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        User::factory(9990)
//            ->hasAttached(Project::factory(),
//                 ['role' => 'contributor'])
//            ->create();

        Task::factory(10106)->create();
    }
}
