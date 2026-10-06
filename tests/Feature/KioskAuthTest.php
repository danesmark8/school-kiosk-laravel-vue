<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class KioskAuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_student_can_login_with_valid_credentials()
    {
        // Arrange – create a student with known PIN
        $student = Student::factory()->create([
            'student_number' => '2024-9999',
            'pin_hash' => Hash::make('1234'),
            'status' => 'active',
        ]);

        // Act – submit login form
        $response = $this->post(route('kiosk.login.submit'), [
            'student_number' => $student->student_number,
            'pin' => '1234',
        ]);

        // Assert – redirected to home with success flash message
        $response->assertRedirect(route('kiosk.home'));
        $response->assertSessionHas('success');
        $this->assertTrue(auth('student')->check());
        $this->assertEquals($student->id, auth('student')->id());
    }
}
