<?php

namespace Modules\LikeModule\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LikeModuleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test LikeModule.
     *
     * @return void
     */
    public function test_backend_likemodules_list_page()
    {
        $this->signInAsAdmin();

        $response = $this->get('app/likemodules');

        $response->assertStatus(200);
    }
}
