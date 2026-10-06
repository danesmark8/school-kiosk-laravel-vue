<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'student_number' => $this->faker->unique()->numerify('S########'),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'course' => $this->faker->word,
            'year_level' => $this->faker->numberBetween(1, 5),
            'pin_hash' => bcrypt('1234'),
            'status' => 'active',
        ];
    }
}
