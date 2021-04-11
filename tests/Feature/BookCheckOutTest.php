<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class BookCheckOutTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function a_book_can_be_checked_out_by_a_signed_in_user()
    {// $this->withoutExceptionHandling();

        $book = factory(Book::class)->create();

        $this->actingAs($user = factory(User::class)->create())
            ->post('api/checkout/' . $user->id);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals(now(), Reservation::first()->check_out_at);
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function only_signed_in_user_can_checkout()
    {// $this->withoutExceptionHandling();

        $book = factory(Book::class)->create();

        $this->post('api/checkout/' . $book->id)->assertRedirect('/login');

        $this->assertCount(0, Reservation::all());
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function only_avilable_book_can_checkout()
    {// $this->withoutExceptionHandling();
        $this->actingAs($user = factory(User::class)->create())
                ->post('api/checkout/123')->assertStatus(404);

        $this->assertCount(0, Reservation::all());
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function a_book_can_be_checked_in_by_a_signed_in_user($value='')
    {
        // $this->withoutExceptionHandling();
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user)
                ->post('api/checkout/'. $book->id);

        $this->actingAs($user)
                ->post('api/checkin/' . $book->id);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals(now(), Reservation::first()->check_out_at);
        $this->assertEquals(now(), Reservation::first()->check_in_at);
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function only_signed_in_user_can_checkin()
    {

        // $this->withoutExceptionHandling();

        $book = factory(Book::class)->create();

        $this->actingAs(factory(User::class)->create())->post('api/checkout/'. $book->id); 

        Auth::logout();
        // $this->post('logout');

        $this->post('api/checkin/' . $book->id)->assertRedirect('/login');

        $this->assertCount(1, Reservation::all());
        $this->assertNull(Reservation::first()->check_in_at);
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function a_404_is_thrown_if_a_book_is_not_checked_out_first()
    {
        // $this->withoutExceptionHandling();
        // $this->expectException(\Exception::class);
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user)->post('api/checkin/'. $book->id)
                ->assertStatus(404);

        $this->assertCount(0, Reservation::all());
    }
}
