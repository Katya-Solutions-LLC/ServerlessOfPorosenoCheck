<?php

namespace Modules\Product\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test Product.
     *
     * @return void
     */
    public function test_backend_products_list_page()
    {
        $this->signInAsAdmin();

        $response = $this->get('app/products');

        $response->assertStatus(200);
    }
}
