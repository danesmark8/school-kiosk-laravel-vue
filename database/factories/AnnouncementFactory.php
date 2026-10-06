<?php

namespace Database\Factories;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Announcement>
 */
class AnnouncementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Announcement::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $types = ['general', 'academic', 'financial', 'emergency', 'kiosk'];

        return [
            'title' => $this->faker->sentence(6),
            'content' => $this->faker->paragraphs(3, true),
            'type' => $this->faker->randomElement($types),
            'is_pinned' => $this->faker->boolean(20),
            'is_active' => true,
            'published_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'expires_at' => $this->faker->optional()->dateTimeBetween('now', '+1 month'),
            'created_by_user_id' => User::factory(),
        ];
    }
}
