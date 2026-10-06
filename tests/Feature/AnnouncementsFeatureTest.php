<?php

namespace Tests\Feature;

use App\Models\Announcement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnnouncementsFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the announcements index page loads and displays active announcements.
     */
    public function test_announcements_index_shows_active_announcements(): void
    {
        // Arrange: create 7 announcements, 6 active, 1 inactive
        Announcement::factory()->count(7)->create([
            'is_active' => true,
            'published_at' => now()->subDay(),
        ]);
        Announcement::factory()->create([
            'is_active' => false,
            'published_at' => now()->subDay(),
        ]);

        // Act
        $response = $this->get(route('kiosk.announcements.index'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('kiosk.announcements.index');
        // Ensure at least one active announcement title appears
        $announcement = Announcement::where('is_active', true)->first();
        $response->assertSeeText($announcement->title);
        // Pagination links should be present when more than 6 announcements
        $response->assertSee('Next');
    }
}
