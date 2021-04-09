<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use App\Models\Author;
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

        $response = $this->post('/api/books', $this->payLoad());

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

        $response = $this->post('/api/books', array_merge($this->payLoad(), ['title' => '']));

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

        $response = $this->post('/api/books', array_merge($this->payLoad(), ['author_id' => '']));

        $response->assertSessionHasErrors('author_id');
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
        $this->post('/api/books', $this->payLoad());

        // get book id
        $book = Book::first();
        $author = Author::first();

        $response = $this->patch($book->path(), [
            'title' => 'New Title',
            'author_id' => 'New Author'
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals($author->id, Book::first()->author_id);

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
        $this->post('/api/books', $this->payLoad());

        // check if book is added
        $this->assertCount(1, Book::all());

        // get book id
        $book = Book::first();

        $response = $this->delete($book->path(), $this->payLoad());

        // check if book is deleted
        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }

    /**
     * A basic feature test example for update.
     *
     * @test
     * @return void
     */
    public function a_new_author_is_auto_added()
    {
        // store book for update
        $this->post('/api/books', $this->payLoad());

        // get book and Author
        $book = Book::first();
        $author = Author::first();

        // dd($book->author_id);
        $this->assertEquals($author->id, $book->author_id);
        $this->assertCount(1, Author::all());
    }

    /**
     * A basic unit test for checking author id on books.
     * @test
     * @return void
     */
    public function an_author_id_is_recorded()
    {
        Book::create([
            'title' => 'Cool title',
            'author_id' => 1
        ]);

        $this->assertCount(1, Book::all());
    }

    private function payLoad()
    {
        return [
            'title' => 'Coool book title',
            'author_id' => 'James'
        ];
    }
}
