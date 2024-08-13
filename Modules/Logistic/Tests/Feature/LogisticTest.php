<?php

namespace Modules\Logistic\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogisticTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test Logistic.
     *
     * @return void
     */
    public function test_backend_logistics_list_page()
    {
        $this->signInAsAdmin();

        $response = $this->get('app/logistics');

        $response->assertStatus(200);
    }
}
