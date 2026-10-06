<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GradesFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the grades index page loads for an authenticated student.
     */
    public function test_grades_page_shows_student_info(): void
    {
        // Arrange: create a student
        $student = Student::factory()->create();

        // Act: act as the student using the 'student' guard
        $response = $this->actingAs($student, 'student')->get(route('kiosk.grades.index'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('kiosk.grades.index');
        $response->assertSeeText($student->full_name);
    }
}
