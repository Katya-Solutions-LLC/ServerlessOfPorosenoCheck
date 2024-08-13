<?php

namespace Modules\Location\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test Location.
     *
     * @return void
     */
    public function test_backend_locations_list_page()
    {
        $this->signInAsAdmin();

        $response = $this->get('app/locations');

        $response->assertStatus(200);
    }
}
