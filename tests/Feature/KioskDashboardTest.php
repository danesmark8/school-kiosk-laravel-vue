<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class KioskDashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_student_can_access_dashboard()
    {
        // Arrange: create a student with a known PIN
        $student = Student::factory()->create([
            'student_number' => '2024-1111',
            'pin_hash' => Hash::make('1234'),
            'first_name' => 'John',
            'status' => 'active',
        ]);

        // Act: log in the student
        $this->post(route('kiosk.login.submit'), [
            'student_number' => $student->student_number,
            'pin' => '1234',
        ])->assertRedirect(route('kiosk.home'));

        // Assert: can view the dashboard and see the student's name
        $response = $this->get(route('kiosk.dashboard'));
        $response->assertStatus(200);
        $response->assertSeeText($student->first_name);
    }
}
