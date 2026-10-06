<?php

namespace Database\Seeders;

use App\Models\AcademicTerm;
use App\Models\Announcement;
use App\Models\Grade;
use App\Models\KioskDevice;
use App\Models\Office;
use App\Models\Role;
use App\Models\Service;
use App\Models\Student;
use App\Models\StudentLedger;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Roles
        $adminRole = Role::firstOrCreate(
            ['slug' => 'admin'],
            ['name' => 'System Administrator']
        );
        $registrarRole = Role::firstOrCreate(
            ['slug' => 'registrar'],
            ['name' => 'Registrar Staff']
        );
        $cashierRole = Role::firstOrCreate(
            ['slug' => 'cashier'],
            ['name' => 'Cashier / Accounting Staff']
        );
        $kioskTechRole = Role::firstOrCreate(
            ['slug' => 'kiosk_tech'],
            ['name' => 'Kiosk Technician']
        );

        // 2. Staff Users
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@school.edu'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('password123'),
                'role_id' => $adminRole->id,
                'is_active' => true,
            ]
        );

        User::firstOrCreate(
            ['email' => 'registrar@school.edu'],
            [
                'name' => 'Registrar Head',
                'password' => Hash::make('password123'),
                'role_id' => $registrarRole->id,
                'is_active' => true,
            ]
        );

        User::firstOrCreate(
            ['email' => 'cashier@school.edu'],
            [
                'name' => 'Chief Cashier',
                'password' => Hash::make('password123'),
                'role_id' => $cashierRole->id,
                'is_active' => true,
            ]
        );

        // 3. Kiosk Devices
        KioskDevice::firstOrCreate(
            ['device_code' => 'KIOSK-01'],
            [
                'name' => 'Main Lobby Kiosk Terminal',
                'location' => 'Main Building - Ground Floor Atrium',
                'ip_address' => '192.168.1.101',
                'is_active' => true,
                'last_heartbeat_at' => now(),
            ]
        );

        KioskDevice::firstOrCreate(
            ['device_code' => 'KIOSK-02'],
            [
                'name' => 'Student Services Kiosk Terminal',
                'location' => 'Finance & Registrar Wing - 2nd Floor',
                'ip_address' => '192.168.1.102',
                'is_active' => true,
                'last_heartbeat_at' => now(),
            ]
        );

        // 4. Offices & Services
        $officesData = [
            [
                'name' => "Registrar's Office",
                'code' => 'REG',
                'services' => [
                    ['name' => 'Transcript & Certifications Request', 'prefix' => 'R', 'time' => 10],
                    ['name' => 'Enrollment & Clearance Inquiry', 'prefix' => 'E', 'time' => 8],
                    ['name' => 'General Academic Information', 'prefix' => 'I', 'time' => 5],
                ],
            ],
            [
                'name' => "Cashier's Office",
                'code' => 'CASH',
                'services' => [
                    ['name' => 'Tuition & Assessment Payment', 'prefix' => 'C', 'time' => 5],
                    ['name' => 'Graduation & Special Fees Payment', 'prefix' => 'G', 'time' => 5],
                ],
            ],
            [
                'name' => 'Accounting Office',
                'code' => 'ACCT',
                'services' => [
                    ['name' => 'SOA Statement Inquiry & Disputes', 'prefix' => 'A', 'time' => 10],
                    ['name' => 'Scholarship Voucher Validation', 'prefix' => 'S', 'time' => 8],
                ],
            ],
            [
                'name' => 'Admissions Office',
                'code' => 'ADM',
                'services' => [
                    ['name' => 'New Student Application & Testing', 'prefix' => 'D', 'time' => 15],
                ],
            ],
        ];

        foreach ($officesData as $officeInfo) {
            $office = Office::firstOrCreate(
                ['code' => $officeInfo['code']],
                ['name' => $officeInfo['name'], 'is_active' => true]
            );

            foreach ($officeInfo['services'] as $serv) {
                Service::firstOrCreate(
                    [
                        'office_id' => $office->id,
                        'name' => $serv['name'],
                    ],
                    [
                        'prefix' => $serv['prefix'],
                        'estimated_time_minutes' => $serv['time'],
                        'is_active' => true,
                    ]
                );
            }
        }

        // 5. Academic Terms
        $pastTerm = AcademicTerm::firstOrCreate(
            ['school_year' => '2024-2025', 'semester' => '1st Semester'],
            ['is_current' => false]
        );

        $currentTerm = AcademicTerm::firstOrCreate(
            ['school_year' => '2024-2025', 'semester' => '2nd Semester'],
            ['is_current' => true]
        );

        // 6. Test Students (PIN is 1234 for all)
        $student1 = Student::firstOrCreate(
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

        Student::firstOrCreate(
            ['student_number' => '2024-0002'],
            [
                'first_name' => 'Maria',
                'last_name' => 'Santos',
                'course' => 'BS Computer Science',
                'year_level' => 2,
                'pin_hash' => Hash::make('1234'),
                'status' => 'active',
            ]
        );

        Student::firstOrCreate(
            ['student_number' => '2024-0003'],
            [
                'first_name' => 'Mark',
                'last_name' => 'Reyes',
                'course' => 'BS Business Administration',
                'year_level' => 4,
                'pin_hash' => Hash::make('1234'),
                'status' => 'active',
            ]
        );

        // 7. Subjects
        $sub1 = Subject::firstOrCreate(['code' => 'IT301'], ['title' => 'Systems Architecture & Integration', 'units' => 3.0]);
        $sub2 = Subject::firstOrCreate(['code' => 'IT302'], ['title' => 'Web Application Development', 'units' => 3.0]);
        $sub3 = Subject::firstOrCreate(['code' => 'CS201'], ['title' => 'Data Structures & Algorithms', 'units' => 3.0]);
        $sub4 = Subject::firstOrCreate(['code' => 'GE101'], ['title' => 'Purposive Communication', 'units' => 3.0]);

        // 8. Grades for Juan Dela Cruz
        // Released Grades
        Grade::updateOrCreate(
            ['student_id' => $student1->id, 'subject_id' => $sub1->id, 'academic_term_id' => $currentTerm->id],
            ['midterm_grade' => '1.50', 'final_grade' => '1.25', 'remarks' => 'Passed', 'is_released' => true, 'released_at' => now()]
        );
        Grade::updateOrCreate(
            ['student_id' => $student1->id, 'subject_id' => $sub2->id, 'academic_term_id' => $currentTerm->id],
            ['midterm_grade' => '1.75', 'final_grade' => '1.50', 'remarks' => 'Passed', 'is_released' => true, 'released_at' => now()]
        );
        Grade::updateOrCreate(
            ['student_id' => $student1->id, 'subject_id' => $sub4->id, 'academic_term_id' => $currentTerm->id],
            ['midterm_grade' => '1.25', 'final_grade' => '1.00', 'remarks' => 'Passed', 'is_released' => true, 'released_at' => now()]
        );
        // Unreleased Grade (Teacher entered, but registrar has NOT released yet)
        Grade::updateOrCreate(
            ['student_id' => $student1->id, 'subject_id' => $sub3->id, 'academic_term_id' => $currentTerm->id],
            ['midterm_grade' => '2.00', 'final_grade' => '1.75', 'remarks' => 'Pending Approval', 'is_released' => false, 'released_at' => null]
        );

        // 9. Statement of Account Ledger Entries for Juan Dela Cruz
        StudentLedger::updateOrCreate(
            ['student_id' => $student1->id, 'academic_term_id' => $currentTerm->id, 'description' => 'Tuition & Miscellaneous Fees (2nd Sem S.Y. 2024-2025)'],
            ['transaction_type' => 'assessment', 'amount' => 25000.00, 'balance_after' => 25000.00, 'due_date' => now()->addDays(30)]
        );
        StudentLedger::updateOrCreate(
            ['student_id' => $student1->id, 'academic_term_id' => $currentTerm->id, 'description' => 'Academic Excellence Scholarship Discount (20%)'],
            ['transaction_type' => 'discount', 'amount' => 5000.00, 'balance_after' => 20000.00, 'due_date' => null]
        );
        StudentLedger::updateOrCreate(
            ['student_id' => $student1->id, 'academic_term_id' => $currentTerm->id, 'description' => 'Preliminary Exam Payment (Official Receipt #78291)'],
            ['transaction_type' => 'payment', 'amount' => 10000.00, 'balance_after' => 10000.00, 'due_date' => null]
        );

        // 10. Announcements
        Announcement::firstOrCreate(
            ['title' => 'Midterm Examination Schedule Announced'],
            [
                'content' => 'Midterm examinations for the 2nd Semester S.Y. 2024-2025 will begin next Monday. Please settle outstanding balances at the Cashier or verify your exam permits at the kiosk.',
                'type' => 'academic',
                'is_pinned' => true,
                'is_active' => true,
                'published_at' => now()->subDay(),
                'expires_at' => now()->addDays(14),
                'created_by_user_id' => $adminUser->id,
            ]
        );

        Announcement::firstOrCreate(
            ['title' => 'Tuition Fee Installment Due Date'],
            [
                'content' => 'The deadline for the 2nd installment of tuition fees is due on the 15th of this month. Payment references can be generated directly via the Kiosk Payments module.',
                'type' => 'financial',
                'is_pinned' => false,
                'is_active' => true,
                'published_at' => now()->subDays(2),
                'expires_at' => now()->addDays(20),
                'created_by_user_id' => $adminUser->id,
            ]
        );

        Announcement::firstOrCreate(
            ['title' => 'Campus Self-Service Kiosks are Now Operational!'],
            [
                'content' => 'Students can now check their Statements of Account, view released semester grades, and queue for Registrar and Cashier services without waiting in crowded lines.',
                'type' => 'kiosk',
                'is_pinned' => true,
                'is_active' => true,
                'published_at' => now(),
                'expires_at' => now()->addDays(30),
                'created_by_user_id' => $adminUser->id,
            ]
        );
    }
}
