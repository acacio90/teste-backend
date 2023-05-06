<?php

namespace Tests\Unit;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;


class BookTest extends TestCase
{
    use InteractsWithDatabase;
    use RefreshDatabase;

    public function testCreateBook()
    {
        $data = [
            'title' => 'O Senhor dos Anéis',
            'author' => 'J. R. R. Tolkien',
            'quantity' => 5
        ];

        $response = $this->json('POST', '/books', $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('books', [
            'title' => $data['title'],
            'author' => $data['author'],
            'quantity' => $data['quantity']
        ]);
    }

    public function testGetBooks()
    {
        $books = Book::factory()->count(5)->create();

        $response = $this->json('GET', '/books');

        $response->assertStatus(200)
            ->assertJsonCount(5)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                    'author',
                    'quantity',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    public function testGetBookById()
    {
        $book = Book::factory()->create();

        $response = $this->json('GET', "/books/{$book->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'quantity' => $book->quantity
            ]);
    }

    public function testUpdateBook()
    {
        $book = Book::factory()->create();

        $data = [
            'title' => 'Novo Título',
            'author' => 'Novo Autor',
            'quantity' => 5
        ];

        $response = $this->json('PUT', "/books/{$book->id}", $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => $data['title'],
            'author' => $data['author'],
            'quantity' => $data['quantity']
        ]);
    }

    public function testDeleteBook()
    {
        $book = Book::factory()->create();

        $response = $this->json('DELETE', "/books/{$book->id}");

        $response->assertStatus(204);
    }
}
