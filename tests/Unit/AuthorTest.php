<?php

namespace Tests\Unit;

use App\Models\Author;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorTest extends TestCase
{
	use RefreshDatabase;
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
