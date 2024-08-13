<?php

namespace Modules\Pet\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PetTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test Pet.
     *
     * @return void
     */
    public function test_backend_pets_list_page()
    {
        $this->signInAsAdmin();

        $response = $this->get('app/pets');

        $response->assertStatus(200);
    }
}
