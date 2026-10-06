<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Verify the student‑authentication flow for the kiosk.
 *
 * @covers \App\Http\Controllers\Kiosk\KioskAuthController
 * @covers \App\Http\Middleware\AuthenticateStudent
 */
class KioskStudentAuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A student can log in with a valid credential pair.
     */
    public function test_student_can_login_and_is_redirected_to_home(): void
    {
        // Create a student via the factory – PIN is '1234' (hashed in the factory).
        $student = Student::factory()->create([
            'student_number' => '2024-0001',
            'pin_hash' => bcrypt('1234'), // ensure known PIN
        ]);

        // POST to the login route.
        $response = $this->post(route('kiosk.login.submit'), [
            'student_number' => $student->student_number,
            'pin' => '1234',
        ]);

        // Expect a redirect to the kiosk home route.
        $response->assertRedirect(route('kiosk.home'));

        // Auth guard should now contain the student.
        $this->assertTrue(auth('student')->check());
        $this->assertSame($student->id, auth('student')->id());
    }

    /**
     * Unauthenticated users are redirected to the login page
     * when trying to access a protected kiosk route.
     */
    public function test_protected_route_requires_authentication(): void
    {
        // Attempt to hit a guarded route (e.g., SOA page) without login.
        $response = $this->get(route('kiosk.soa.index'));

        // Middleware should redirect to the login page.
        $response->assertRedirect(route('kiosk.login'));

        // No student should be authenticated.
        $this->assertFalse(auth('student')->check());
    }
}
