<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Book;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_be_store_books()
    {
        $this->withoutExceptionHandling();
        $data = [
            'name' => 'test book',
            'description' => 'test  description'
        ];
        $response = $this->postJson('/api/book', $data);
        $response->assertStatus(201);
        $this->assertCount(1, Book::all());
        $response->assertJson([
            'message' => 'Book Stored'
        ]);
    }

    /** @test */
    public function user_can_be_read_all_books()
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson('/api/book');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }

    /** @test */
    public function user_can_be_update_book()
    {
        $this->withoutExceptionHandling();
        $data = [
            'name' => 'test book',
            'description' => 'test  description'
        ];
        $this->postJson('/api/book', $data);
        $update_data = [
            'name' => 'updated name',
            'description' => 'updated description'
        ];
        $response = $this->patchJson('/api/book/1', $update_data);
        $response->assertStatus(200);
        $book = Book::findOrFail(1);
        $this->assertEquals('updated name', $book->name);
        $this->assertEquals('updated description', $book->description);
        $response->assertJson([
            'message' => "Updated Successfully"
        ]);
    }

    /** @test */
    public function user_can_be_delete_book()
    {
        $this->withoutExceptionHandling();
        $data = [
            'name' => 'test book',
            'description' => 'test  description'
        ];
        $this->postJson('/api/book', $data);
        $response = $this->deleteJson('/api/book/1');
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Remove Record Successfully'
        ]);
    }
}
