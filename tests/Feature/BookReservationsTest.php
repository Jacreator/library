<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookReservationsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example .
     * @test
     * @return void
     */
    public function a_book_can_be_checked_out()
    {
        $this->withoutExceptionHandling();
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();

        $book->checkOut($user);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals(now(), Reservation::first()->check_out_at);
    }

    /**
     * A basic unit test example .
     * @test
     * @return void
     */
    public function a_book_can_be_returned()
    {
        $this->withoutExceptionHandling();
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();

        $book->checkOut($user);

        $book->checkIn($user);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals(now(), Reservation::first()->check_in_at);
    }

    /**
     * A basic unit test example .
     * @test
     * @return void
     */
    public function a_user_can_check_out_a_book_twice($value='')
    {
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();

        // first check out
        $book->checkOut($user);

        // first check in
        $book->checkIn($user);

        // second check out
        $book->checkOut($user);

        $this->assertCount(2, Reservation::all());
        $this->assertEquals($user->id, Reservation::findOrFail(2)->user_id);
        $this->assertEquals($book->id, Reservation::findOrFail(2)->book_id);
        $this->assertNull(Reservation::findOrFail(2)->check_in_at);
        $this->assertEquals(now(), Reservation::findOrFail(2)->check_out_at);

        // second check in
        $book->checkIn($user);

        $this->assertCount(2, Reservation::all());
        $this->assertEquals($user->id, Reservation::findOrFail(2)->user_id);
        $this->assertEquals($book->id, Reservation::findOrFail(2)->book_id);
        $this->assertNotNull(Reservation::findOrFail(2)->check_in_at);
        $this->assertEquals(now(), Reservation::findOrFail(2)->check_in_at);
    }

    /**
     * A basic unit test example .
     * @test
     * @return void
     */
    public function if_not_checked_out_exception_is_thrown()
    {
        $this->expectException(\Exception::class);

        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();

        // first check in
        $book->checkIn($user);

    }
}
