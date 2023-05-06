<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Student;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoanTest extends TestCase
{
    use InteractsWithDatabase;
    use RefreshDatabase;

    public function testCreateLoan()
    {
        $book = Book::factory()->create();
        $student = Student::factory()->create();

        $data = [
            'book_id' => $book->id,
            'student_id' => $student->id,
            'loan_date' => now()->toDateString(),
            'return_date' => now()->addDays(7)->toDateString(),
        ];

        $response = $this->json('POST', '/loans', $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('loans', [
            'book_id' => $data['book_id'],
            'student_id' => $data['student_id'],
            'loan_date' => $data['loan_date'],
            'return_date' => $data['return_date'],
        ]);
    }

    public function testGetLoans()
    {
    $student = Student::factory()->create();
    $book = Book::factory()->create();

    $loan1 = Loan::factory()->create([
        'student_id' => $student->id,
        'book_id' => $book->id,
        'loan_date' => now()->subDays(10),
        'return_date' => now()->addDays(10)
    ]);

    $loan2 = Loan::factory()->create([
        'student_id' => $student->id,
        'book_id' => $book->id,
        'loan_date' => now()->subDays(5),
        'return_date' => now()->addDays(15)
    ]);

    $response = $this->json('GET', "/loans");

    $response->assertStatus(200)
        ->assertJsonCount(2)
        ->assertJson([
            [
                'id' => $loan1->id,
                'student_id' => $student->id,
                'book_id' => $book->id,
                'loan_date' => $loan1->loan_date->format('Y-m-d H:i:s'),
                'return_date' => $loan1->return_date->format('Y-m-d H:i:s')
            ],
            [
                'id' => $loan2->id,
                'student_id' => $student->id,
                'book_id' => $book->id,
                'loan_date' => $loan2->loan_date->format('Y-m-d H:i:s'),
                'return_date' => $loan2->return_date->format('Y-m-d H:i:s')
            ]
        ]);
    }


    public function testGetLoanById()
    {
        $student = Student::factory()->create();
        $book = Book::factory()->create();
    
        $loan = Loan::factory()->create([
            'student_id' => $student->id,
            'book_id' => $book->id
        ]);
    
        $response = $this->json('GET', "/loans/{$loan->id}");
    
        $response->assertStatus(200)
            ->assertJson([
                'id' => $loan->id,
                'book_id' => $book->id,
                'student_id' => $student->id,
                'loan_date' => $loan->loan_date->format('Y-m-d H:i:s'),
                'return_date' => $loan->return_date->format('Y-m-d H:i:s')
            ]);
    }
    

    public function testUpdateLoan()
    {
        $book = Book::factory()->create();
        $student = Student::factory()->create();

        $loan = Loan::factory()->create([
            'book_id' => $book->id,
            'student_id' => $student->id
        ]);

        $newData = [
            'book_id' => $book->id,
            'student_id' => $student->id,
            'loan_date' => now()->toDateString(),
            'return_date' => now()->toDateString(),
        ];

        $responseUpdate = $this->json('PUT', "/loans/{$loan->id}", $newData);

        $responseUpdate->assertStatus(200)
            ->assertJson([
                'id' => $loan->id,
                'student_id' => $student->id,
                'book_id' => $book->id,
                'loan_date' => now()->toDateString(),
                'return_date' => now()->toDateString()
            ]);
    }


    public function testDeleteLoan()
    {
        $book = Book::factory()->create();
        $student = Student::factory()->create();

        $loan = Loan::factory()->create([
            'book_id' => $book->id,
            'student_id' => $student->id
        ]);

        $response = $this->json('DELETE', "/loans/{$loan->id}");

        $response->assertStatus(204);
    }
}
