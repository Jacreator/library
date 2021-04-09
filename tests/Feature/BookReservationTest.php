<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @test
     * @return void
     */
    public function a_book_can_be_add()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/api/books', [
            'title' => 'Cool book title',
            'author' => 'James'
        ]);

        // $response->assertStatus(200);
        $response->assertOk();
        $this->assertCount(1, Book::all());
    }

    /**
     * A basic feature test example.
     *
     * @test
     * @return void
     */
    public function a_book_title_is_required()
    {

        $response = $this->post('/api/books', [
            'title' => '',
            'author' => 'James'
        ]);

        $response->assertSessionHasErrors('title');
    }

    /**
     * A basic feature test example.
     *
     * @test
     * @return void
     */
    public function a_book_author_is_required()
    {

        $response = $this->post('/api/books', [
            'title' => 'Coool book title',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }

    /**
     * A basic feature test example for update.
     *
     * @test
     * @return void
     */
    public function a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();

        // store book for update
        $this->post('/api/books', [
            'title' => 'Coool book title',
            'author' => 'James'
        ]);

        // get book id
        $book = Book::first()->id;

        $response = $this->patch('api/books/'. $book, [
            'title' => 'New Title',
            'author' => 'New Author'
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);
    }
}
