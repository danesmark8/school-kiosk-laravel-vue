<?php

namespace Database\Factories;

use App\Models\Office;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Office> */
class OfficeFactory extends Factory
{
    protected $model = Office::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'code' => strtoupper($this->faker->unique()->lexify('???')),
            'is_active' => true,
        ];
    }
}
