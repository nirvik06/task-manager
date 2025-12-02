<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Task;
use Carbon\Carbon;

class SampleTasksSeeder extends Seeder
{
    public function run()
    {
        // Use the first user (change if needed)
        $user = User::first();

        if (! $user) {
            $this->command->warn("No users found! Run user seeder first.");
            return;
        }

        Task::factory()->count(15)->create([
            'user_id' => $user->id
        ]);
    }
}