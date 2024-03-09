<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'task_name' => fake()->word(),
            'task_description' => fake()->sentence(),
            'deadline' => fake()->date(),
            'project_id' => fake()->numberBetween(1, 100000),
            'assigner_id' => fake()->numberBetween(1, 100000),
            'status' => fake()->randomElement(['not_started', 'in_progress', 'done', 'pause']),
            'priority' => fake()->randomElement(['low', 'medium', 'high']),
        ];
    }
}
