<?php

namespace Tests\Unit;

use App\Models\Book;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
	use RefreshDatabase;
    // /**
    //  * A basic unit test for checking author id on books.
    //  * @test
    //  * @return void
    //  */
    // public function an_author_id_is_recorded()
    // {
    //     Book::create([
    //     	'title' => 'Cool title',
    //     	'author_id' => 'James'
    //     ]);

    //     $this->assertCount(1, Book::all());
    // }
}
