<?php

namespace Tests\Unit;

use App\Models\Student;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentTest extends TestCase
{
    use InteractsWithDatabase;
    use RefreshDatabase;

    public function testCreateStudent()
    {
        $data = [
            'name' => 'Fulano de Tal',
            'email' => 'fulano@example.com',
        ];

        $response = $this->json('POST', '/students', $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('students', [
            'name' => $data['name'],
            'email' => $data['email']
        ]);
    }

    public function testGetStudents()
    {
        $students = Student::factory()->count(5)->create();

        $response = $this->json('GET', '/students');

        $response->assertStatus(200)
            ->assertJsonCount(5)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    public function testGetStudentById()
    {
        $student = Student::factory()->create();

        $response = $this->json('GET', "/students/{$student->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $student->id,
                'name' => $student->name,
                'email' => $student->email,
            ]);
    }

    public function testUpdateStudent()
    {
        $student = Student::factory()->create();

        $data = [
            'name' => 'Nome',
            'email' => 'novo@example.com',
        ];

        $response = $this->json('PUT', "/students/{$student->id}", $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }

    public function testDeleteStudent()
    {
        $student = Student::factory()->create();

        $response = $this->json('DELETE', "/students/{$student->id}");

        $response->assertStatus(204);
    }
}