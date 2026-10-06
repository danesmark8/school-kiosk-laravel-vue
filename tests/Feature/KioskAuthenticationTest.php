<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class KioskAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Ensure at least one active test student exists
        Student::firstOrCreate(
            ['student_number' => '2024-0001'],
            [
                'first_name' => 'Juan',
                'last_name' => 'Dela Cruz',
                'course' => 'BS Information Technology',
                'year_level' => 3,
                'pin_hash' => Hash::make('1234'),
                'status' => 'active',
            ]
        );
    }

    /**
     * Test public kiosk home screen is accessible without login.
     */
    public function test_kiosk_home_is_accessible_to_public(): void
    {
        $response = $this->get('/kiosk');

        $response->assertStatus(200);
        $response->assertSee('CAMPUS SELF-SERVICE KIOSK');
        $response->assertSee('Queue Management');
    }

    /**
     * Test protected kiosk pages redirect unauthenticated students to login.
     */
    public function test_protected_kiosk_services_require_student_authentication(): void
    {
        $gradesResponse = $this->get('/kiosk/grades');
        $gradesResponse->assertRedirect('/kiosk/login');

        $soaResponse = $this->get('/kiosk/soa');
        $soaResponse->assertRedirect('/kiosk/login');

        $paymentsResponse = $this->get('/kiosk/payments');
        $paymentsResponse->assertRedirect('/kiosk/login');
    }

    /**
     * Test student can log in with valid Student Number and PIN.
     */
    public function test_student_can_authenticate_with_valid_pin(): void
    {
        $response = $this->post('/kiosk/login', [
            'student_number' => '2024-0001',
            'pin' => '1234',
        ]);

        $response->assertRedirect('/kiosk');
        $this->assertAuthenticated('student');
    }

    /**
     * Test student login fails with incorrect PIN.
     */
    public function test_student_login_fails_with_invalid_pin(): void
    {
        $response = $this->post('/kiosk/login', [
            'student_number' => '2024-0001',
            'pin' => '9999',
        ]);

        $response->assertSessionHasErrors('student_number');
        $this->assertGuest('student');
    }

    /**
     * Test authenticated student can access private grades page.
     */
    public function test_authenticated_student_can_view_grades_page(): void
    {
        $student = Student::where('student_number', '2024-0001')->first();

        $response = $this->actingAs($student, 'student')->get('/kiosk/grades');

        $response->assertStatus(200);
        $response->assertSee('Grades Inquiry');
        $response->assertSee('Juan Dela Cruz');
    }

    /**
     * Test student logout clears authentication.
     */
    public function test_student_can_logout_from_kiosk(): void
    {
        $student = Student::where('student_number', '2024-0001')->first();

        $response = $this->actingAs($student, 'student')->post('/kiosk/logout');

        $response->assertRedirect('/kiosk');
        $this->assertGuest('student');
    }

    /**
     * Test browser cache headers are properly injected for kiosk security.
     */
    public function test_kiosk_responses_contain_no_cache_headers(): void
    {
        $response = $this->get('/kiosk');

        $this->assertStringContainsString('no-store', (string) $response->headers->get('Cache-Control'));
        $this->assertStringContainsString('no-cache', (string) $response->headers->get('Cache-Control'));
        $this->assertStringContainsString('must-revalidate', (string) $response->headers->get('Cache-Control'));
        $response->assertHeader('Pragma', 'no-cache');
    }
}
