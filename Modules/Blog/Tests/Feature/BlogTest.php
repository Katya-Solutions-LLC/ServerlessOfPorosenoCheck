<?php

namespace Modules\Blog\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BlogTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test Blog.
     *
     * @return void
     */
    public function test_backend_blogs_list_page()
    {
        $this->signInAsAdmin();

        $response = $this->get('app/blogs');

        $response->assertStatus(200);
    }
}
