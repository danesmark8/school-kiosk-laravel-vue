<?php

namespace Tests\Feature;

use App\Models\QueueTicket;
use App\Models\Service;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KioskQueueTicketTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function student_can_request_a_queue_ticket()
    {
        // Create a student and a service
        $student = Student::factory()->create();
        $service = Service::factory()->create(['prefix' => 'R']);

        // Authenticate as the student (assuming student guard)
        $this->actingAs($student, 'student');

        // Submit the ticket request
        $response = $this->post(route('kiosk.queue.store'), [
            'service_id' => $service->id,
        ]);

        // Verify we are redirected to the dashboard with a flash message
        $response->assertRedirect(route('kiosk.dashboard'));
        $response->assertSessionHas('success');

        // Verify a queue ticket was created
        $this->assertDatabaseHas('queue_tickets', [
            'student_id' => $student->id,
            'service_id' => $service->id,
        ]);

        // Fetch the ticket and check the ticket number format
        $ticket = QueueTicket::where('student_id', $student->id)->first();
        $this->assertNotNull($ticket);
        $this->assertMatchesRegularExpression('/^'.$service->prefix.'-\d{3}$/', $ticket->ticket_number);
    }
}
