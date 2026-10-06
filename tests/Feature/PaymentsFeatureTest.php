<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentsFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the payments page loads for an authenticated student.
     */
    public function test_payments_page_shows_student_info(): void
    {
        // Arrange: create a student
        $student = Student::factory()->create();

        // Act: act as the student using the 'student' guard
        $response = $this->actingAs($student, 'student')->get(route('kiosk.payments.index'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('kiosk.payments.index');
        $response->assertSeeText($student->full_name);
    }
}
