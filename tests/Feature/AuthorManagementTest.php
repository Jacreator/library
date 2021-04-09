<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Author;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function an_author_can_be_created()
    {

        $this->post('/api/authors', [
            'name' => 'James',
            'dob' => '05/14/2021'
        ]);

        $author = Author::all();

        $this->assertCount(1, $author);
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);
        $this->assertEquals('2021/14/05', $author->first()->dob->format('Y/d/m'));
        // $response->assertRedirect($author->path());
    }

    /**
     * A basic unit test example.
     * @test
     * @return void
     */
    public function only_name_is_required_to_create_an_author()
    {
        Author::firstOrcreate([
            'name' => 'James Author'
        ]);

        $this->assertCount(1, Author::all());
    }
}
