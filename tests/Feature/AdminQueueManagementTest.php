<?php

namespace Tests\Feature;

use App\Models\Office;
use App\Models\QueueTicket;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminQueueManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_access_queue_dashboard()
    {
        // Ensure roles and admin user exist via seeder
        $this->seed();
        $admin = User::where('email', 'admin@school.edu')->first();
        $response = $this->actingAs($admin)->get(route('admin.queue.index'));
        $response->assertStatus(200);
        $response->assertViewIs('kiosk.queue.manage');
    }

    /** @test */
    public function admin_can_call_next_ticket()
    {
        $this->seed();
        $admin = User::where('email', 'admin@school.edu')->first();
        // Create office, service and waiting ticket
        $office = Office::factory()->create();
        $service = Service::create([
            'office_id' => $office->id,
            'name' => 'Test Service',
            'prefix' => 'T',
            'estimated_time_minutes' => 5,
            'is_active' => true,
        ]);
        $ticket = QueueTicket::create([
            'service_id' => $service->id,
            'ticket_number' => 'T001',
            'status' => 'waiting',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.queue.callNext'), [
            'service_id' => $service->id,
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('queue_tickets', [
            'id' => $ticket->id,
            'status' => 'called',
        ]);
    }

    /** @test */
    public function non_admin_cannot_access_admin_routes()
    {
        $this->seed();
        $student = User::where('email', 'registrar@school.edu')->first();
        $response = $this->actingAs($student)->get(route('admin.queue.index'));
        $response->assertStatus(403);
    }
}
