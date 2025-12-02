<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class TaskFactory extends Factory
{
    public function definition()
    {
        return [
            'title'       => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'status'      => $this->faker->randomElement(['pending','in_progress','done']),
            'due_date'    => Carbon::now()->addDays(rand(1, 10))->toDateString(),
        ];
    }
}