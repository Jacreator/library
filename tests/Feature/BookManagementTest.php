<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookManagementTest extends TestCase
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
        // $this->withoutExceptionHandling();

        $response = $this->post('/api/books', [
            'title' => 'Cool book title',
            'author' => 'James'
        ]);

        $this->assertCount(1, Book::all());
        $response->assertRedirect(Book::first()->path());

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

        // store book for update
        $this->post('/api/books', [
            'title' => 'Coool book title',
            'author' => 'James'
        ]);

        // get book id
        $book = Book::first();

        $response = $this->patch($book->path(), [
            'title' => 'New Title',
            'author' => 'New Author'
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);

        $response->assertRedirect($book->fresh()->path());
    }

    /**
     * A basic feature test example for update.
     *
     * @test
     * @return void
     */
    public function a_book_can_be_deleted()
    {

        // store book for update
        $this->post('/api/books', [
            'title' => 'Coool book title',
            'author' => 'James'
        ]);

        // check if book is added
        $this->assertCount(1, Book::all());

        // get book id
        $book = Book::first();

        $response = $this->delete($book->path(), [
            'title' => 'New Title',
            'author' => 'New Author'
        ]);

        // check if book is deleted
        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }
}
