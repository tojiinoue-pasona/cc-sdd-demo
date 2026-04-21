<?php

namespace Database\Factories;

use App\Enums\TodoStatus;
use App\Models\Todo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Todo>
 */
class TodoFactory extends Factory
{
    protected $model = Todo::class;

    public function definition(): array
    {
        return [
            'title'       => $this->faker->sentence(4),
            'description' => $this->faker->optional()->paragraph(),
            'status'      => $this->faker->randomElement(TodoStatus::cases()),
        ];
    }

    public function pending(): static
    {
        return $this->state(['status' => TodoStatus::Pending]);
    }

    public function inProgress(): static
    {
        return $this->state(['status' => TodoStatus::InProgress]);
    }

    public function done(): static
    {
        return $this->state(['status' => TodoStatus::Done]);
    }
}
