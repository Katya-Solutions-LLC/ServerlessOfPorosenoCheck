<?php

namespace Modules\Product\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Models\Cart;

class CartTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      if(env('IS_DUMMY_DATA')) {
        Cart::Create([
          "product_id" => 1,
          "product_variation_id"=> 1,
          "qty"=> 1,
          "user_id"=> 3,
          "location_id" => 1
        ]);
        Cart::Create([
          "product_id" => 1,
          "product_variation_id"=> 1,
          "qty"=> 1,
          "user_id"=> 4,
          "location_id" => 1
        ]);
        Cart::Create([
          "product_id" => 1,
          "product_variation_id"=> 1,
          "qty"=> 1,
          "user_id"=> 5,
          "location_id" => 1
        ]);
        Cart::Create([
          "product_id" => 1,
          "product_variation_id"=> 1,
          "qty"=> 1,
          "user_id"=> 6,
          "location_id" => 1
        ]);

        Cart::Create([
          "product_id" => 50,
          "product_variation_id"=> 121,
          "qty"=> 1,
          "user_id"=> 2,
          "location_id" => 1
        ]);
        Cart::Create([
          "product_id" => 51,
          "product_variation_id"=> 123,
          "qty"=> 1,
          "user_id"=> 2,
          "location_id" => 1
        ]);

        Cart::Create([
          "product_id" => 55,
          "product_variation_id"=> 131,
          "qty"=> 1,
          "user_id"=> 7,
          "location_id" => 1
        ]);
        Cart::Create([
          "product_id" => 56,
          "product_variation_id"=> 134,
          "qty"=> 1,
          "user_id"=> 7,
          "location_id" => 1
        ]);

        Cart::Create([
          "product_id" => 58,
          "product_variation_id"=> 139,
          "qty"=> 1,
          "user_id"=> 8,
          "location_id" => 1
        ]);
        Cart::Create([
          "product_id" => 59,
          "product_variation_id"=> 142,
          "qty"=> 1,
          "user_id"=> 8,
          "location_id" => 1
        ]);

        Cart::Create([
          "product_id" => 61,
          "product_variation_id"=> 146,
          "qty"=> 1,
          "user_id"=> 9,
          "location_id" => 1
        ]);
        Cart::Create([
          "product_id" => 62,
          "product_variation_id"=> 147,
          "qty"=> 1,
          "user_id"=> 9,
          "location_id" => 1
        ]);

        Cart::Create([
          "product_id" => 64,
          "product_variation_id"=> 149,
          "qty"=> 1,
          "user_id"=> 10,
          "location_id" => 1
        ]);
        Cart::Create([
          "product_id" => 65,
          "product_variation_id"=> 150,
          "qty"=> 1,
          "user_id"=> 10,
          "location_id" => 1
        ]);
        // Cart::Create([
        //   "product_id" => 63,
        //   "product_variation_id"=> 148,
        //   "qty"=> 1,
        //   "user_id"=> 10,
        //   "location_id" => 1
        // ]);
        
      }
    }
}
