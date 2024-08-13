<?php

namespace Modules\Event\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test Event.
     *
     * @return void
     */
    public function test_backend_events_list_page()
    {
        $this->signInAsAdmin();

        $response = $this->get('app/events');

        $response->assertStatus(200);
    }
}
