<?php

namespace Database\Factories;

use App\Models\Reading;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReadingFactory extends Factory
{
    protected $model = Reading::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'read_on' => $this->faker->date(),
            'impression' => $this->faker->text(50),
        ];
    }
}

