<?php

namespace Tests\Feature;

use App\Models\School;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class AccessControlTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        app(PermissionRegistrar::class)->forgetCachedPermissions();
        foreach (['Administrator', 'Coordinator', 'Teacher', 'Student'] as $role) {
            Role::findOrCreate($role, 'web');
        }
    }

    public function test_guests_are_sent_to_login(): void
    {
        foreach (['/home', '/schools', '/administrators', '/myHomeworks', '/projects'] as $uri) {
            $this->get($uri)->assertRedirect('/login');
        }
    }

    public function test_self_registration_is_disabled(): void
    {
        $this->get('/register')->assertNotFound();
        $this->post('/register', [
            'name' => 'Intruso',
            'email' => 'intruso@example.com',
            'password' => 'secret-password',
            'password_confirmation' => 'secret-password',
        ])->assertNotFound();

        $this->assertDatabaseMissing('users', ['email' => 'intruso@example.com']);
    }

    public function test_student_cannot_create_administrators(): void
    {
        $student = $this->student();

        $this->actingAs($student)->post('/administrators/store', [
            'name' => 'Nuevo admin',
            'email' => 'nuevo-admin@example.com',
            'phone' => '3001234567',
            'password' => 'secret-password',
        ])->assertForbidden();

        $this->assertDatabaseMissing('users', ['email' => 'nuevo-admin@example.com']);
    }

    public function test_administrator_can_create_administrators(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Administrator');

        $this->actingAs($admin)->post('/administrators/store', [
            'name' => 'Nuevo admin',
            'email' => 'nuevo-admin@example.com',
            'phone' => '3001234567',
            'password' => 'secret-password',
        ])->assertRedirect('/administrators');

        $created = User::where('email', 'nuevo-admin@example.com')->firstOrFail();
        $this->assertTrue($created->hasRole('Administrator'));
    }

    public function test_role_sections_are_restricted(): void
    {
        $student = $this->student();

        foreach (['/schools', '/coordinators', '/categories', '/teachers', '/classrooms', '/syllabus', '/chooseUserList'] as $uri) {
            $this->actingAs($student)->get($uri)->assertForbidden();
        }
    }

    public function test_students_only_see_their_own_academic_history(): void
    {
        $student = $this->student();
        $classmate = $this->student();

        $this->actingAs($student)->get("/academicHistories/{$classmate->id}")->assertForbidden();
        $this->actingAs($student)->get("/academicHistories/{$student->id}")->assertOk();
    }

    public function test_students_cannot_touch_someone_elses_submission(): void
    {
        Storage::fake('public');
        $owner = $this->student();
        $intruder = $this->student();
        $schoolId = Student::where('user_id', $owner->id)->value('school_id');

        $classroomId = DB::table('classrooms')->insertGetId(['code' => 'ROB-'.$owner->id, 'name' => 'Robótica 607', 'school_id' => $schoolId]);
        $homeworkId = DB::table('homework')->insertGetId([
            'title' => 'Seguidor de línea',
            'percent' => 20,
            'requiredFile' => 'pdf',
            'classroom_id' => $classroomId,
        ]);
        $submissionId = DB::table('uploaded_homeworks')->insertGetId([
            'score' => 0,
            'homework_id' => $homeworkId,
            'user_id' => $owner->id,
        ]);

        $this->actingAs($intruder)->get("/detailMyHomework/{$submissionId}")->assertNotFound();
        $this->actingAs($intruder)->post('/uploadMyHomework', [
            'uploadedHomework_id' => $submissionId,
            'homeworkFile' => UploadedFile::fake()->create('entrega.pdf', 10, 'application/pdf'),
        ])->assertNotFound();

        $this->assertDatabaseHas('uploaded_homeworks', ['id' => $submissionId, 'path' => null, 'status' => 'notUploaded']);
    }

    public function test_plaintext_student_endpoint_is_gone(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Administrator');

        $this->actingAs($admin)->post('/students/finalSave', [
            'name' => 'Estudiante',
            'email' => 'plain@example.com',
            'password' => 'plain-password',
        ])->assertStatus(405);

        $this->assertDatabaseMissing('users', ['email' => 'plain@example.com']);
    }

    private function student(): User
    {
        $school = School::query()->forceCreate([
            'name' => 'Colegio de prueba',
            'address' => 'Calle 1 # 2-3',
            'city' => 'Bogota',
            'country' => 'Colombia',
            'is_enable' => 1,
        ]);

        $user = User::factory()->create(['role' => 'Student']);
        $user->assignRole('Student');
        Student::query()->forceCreate(['user_id' => $user->id, 'school_id' => $school->id]);

        return $user;
    }
}
