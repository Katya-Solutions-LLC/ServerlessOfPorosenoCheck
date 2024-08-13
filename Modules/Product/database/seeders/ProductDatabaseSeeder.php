<?php

namespace Modules\Product\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Modules\Product\Models\Product;
use Modules\MenuBuilder\Models\MenuBuilder;
use Modules\Product\Models\ProductGallery;
use Modules\Product\Models\ProductVariation;
use Modules\Product\Models\ProductVariationStock;
use Modules\Product\Models\ProductVariationCombination;
use Modules\Location\Models\Location;
use Modules\Tag\Models\Tag;
use Illuminate\Support\Str;
class ProductDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $this->call(ProductCategoryTableSeeder::class);
        $this->call(BrandsTableSeeder::class);
        $this->call(UnitsTableSeeder::class);
        $this->call(VariationsTableSeeder::class);
        
        // if(env('IS_DUMMY_DATA')) {
        //   $products = $this->productList();
        //   foreach ($products as $key => $value) {
        //     $this->createProduct($value);
        //   }
        // }

        $this->call(ProductsTableSeeder::class);
        $this->call(ProductTagsTableSeeder::class);
        $this->call(ProductVariationsTableSeeder::class);
        $this->call(ProductVariationCombinationsTableSeeder::class);
        $this->call(ProductVariationStocksTableSeeder::class);

        $this->call(CartTableSeeder::class);
        $this->call(OrderTableSeeder::class);
        $this->call(ProductReviewTableSeeder::class);

    }

    // protected function createProduct($request) {
    //   $product                    = new Product;
    //     $product->name              = $request['name'];
    //     $product->slug              = Str::slug($request['name'], '-') . '-' . strtolower(Str::random(5));
    //     $product->brand_id          = $request['brand_id'];
    //     $product->unit_id           = $request['unit_id'];
    //     $product->sell_target       = $request['sell_target'] ?? 0;

    //     $product->description       = $request['description'];
    //     $product->short_description = $request['short_description'];

    //     if ($request['has_variation'] && $request['combinations'] !='undefined') {
    //         $product->min_price = min(array_column($request['combinations'], 'price'));
    //         $product->max_price = max(array_column( $request['combinations'], 'price'));
    //     } else {
    //         $product->min_price = $request['price'];
    //         $product->max_price = $request['price'];
    //     }

    //     # discount
    //     $product->discount_value    = $request['discount_value'] ?? 0;
    //     $product->discount_type     = $request['discount_type'] ?? null;

    //     // if ($request['date_range'] != null) {
    //     //     if (Str::contains($request['date_range'], 'to')) {
    //     //         $date_var = explode(" to ", $request['date_range']);
    //     //     } else {
    //     //         $date_var = [date("d-m-Y"), date("d-m-Y")];
    //     //     }
    //     //     $product->discount_start_date = strtotime($date_var[0]);
    //     //     $product->discount_end_date   = strtotime($date_var[1]);
    //     // }

    //     # stock qty based on all variations / no variation
    //     if ($request['has_variation'] == 1 && is_array($request['combinations']) && !empty($request['combinations'])) {
    //         $product->stock_qty = max(array_column($request['combinations'], 'stock'));
    //     } else {
    //         $product->stock_qty = $request['stock'];
    //     }


    //     $product->status         = $request['status'];
    //     $product->has_variation        = ($request['has_variation'] == 1 && count($request['combinations']) > 0) ? 1 : 0;


    //     # shipping info
    //     $product->standard_delivery_hours    = $request['standard_delivery_hours'] ?? 72;
    //     $product->express_delivery_hours     = $request['express_delivery_hours'] ?? 24;
    //     $product->min_purchase_qty     = $request['min_purchase_qty'] ?? 1;
    //     $product->max_purchase_qty     = $request['max_purchase_qty'] ?? 1;

    //     $product->save();

    //       # tags
    //     $tag_ids = [];
    //     foreach ($request['tags'] as $key => $value) {
    //         $tag = Tag::updateOrCreate(['name' => $value], ['name' => $value]);
    //         $tag_ids[] = $tag->id;
    //     }
    //     $product->tags_data()->sync($tag_ids);

    //     # category

    //     $category_ids = [];

    //     if (! empty($request['category_ids'])) {
    //         $product->categories()->sync($request['category_ids']);
    //     }

    //     $location = Location::where('is_default', 1)->first();
    //     if($request['has_variation'] == 1) {
    //       if(is_array($request['combinations']) && !empty($request['combinations']))  {
    //         foreach ($request['combinations'] as $variation) {
    //             $product_variation              = new ProductVariation;
    //             $product_variation->product_id  = $product->id;
    //             $product_variation->variation_key        = $variation['variation_key'];
    //             $product_variation->price       = $variation['price'];
    //             $product_variation->sku         = $variation['sku'];
    //             $product_variation->code         = $variation['code'];
    //             $product_variation->save();

    //             $product_variation_stock                              = new ProductVariationStock;
    //             $product_variation_stock->product_variation_id        = $product_variation->id;
    //             $product_variation_stock->location_id                 = $location->id;
    //             $product_variation_stock->stock_qty                   = $variation['stock'];
    //             $product_variation_stock->save();

    //             foreach (array_filter(explode("/", $variation['variation_key'])) as $combination) {
    //                 $product_variation_combination                         = new ProductVariationCombination;
    //                 $product_variation_combination->product_id             = $product->id;
    //                 $product_variation_combination->product_variation_id   = $product_variation->id;
    //                 $product_variation_combination->variation_id           = explode(":", $combination)[0];
    //                 $product_variation_combination->variation_value_id     = explode(":", $combination)[1];
    //                 $product_variation_combination->save();
    //             }
    //         }
    //       }
    //     } else {
    //         $variation              = new ProductVariation;
    //         $variation->product_id  = $product->id;
    //         $variation->sku         = $request['sku'];
    //         $variation->code         = $request['code'];
    //         $variation->price       = $request['price'];
    //         $variation->save();
    //         $product_variation_stock                          = new ProductVariationStock;
    //         $product_variation_stock->product_variation_id    = $variation->id;
    //         $product_variation_stock->location_id             = $location->id;
    //         $product_variation_stock->stock_qty               = $request['stock'];
    //         $product_variation_stock->save();
    //     }
    // }

    // protected function productList() {
    //   return [
    //     [
    //       'name' => 'Sojoss Simply Beef Freeze-Dried Dog Treats, 4-oz bag',
    //       'brand_id' => '1',
    //       'unit_id' => '1',
    //       'description' => '<p>Bite Sized Treat, Big sized Flavor: Simply Beef is 100% raw, freeze dried meat is the healthy and flavorful way to train your pup, or simply reward him for being the best dog ever; it’s the perfect treat for every occasion.</p>',
    //       'short_description' => 'Bite Sized Treat, Big sized Flavor: Simply Beef is 100% raw',
    //       'status' => true,
    //       'has_variation' => '0',
    //       'tags' => ["Sojoss"],
    //       'category_ids' => ["1"],
    //       'has_variation' => '1',
    //       'combinations' => [
    //         [
    //           'variation_key' => '1:1',
    //           'price' => 20 ,
    //           'stock' => 10 ,
    //           'code' => 'small' ,
    //           'sku' => 'small' ,
    //         ],
    //         [
    //           'variation_key' => '1:2',
    //           'price' => 20 ,
    //           'stock' => 10 ,
    //           'code' => 'mediam' ,
    //           'sku' => 'mediam' ,
    //         ],
    //         [
    //           'variation_key' => '1:3',
    //           'price' => 20 ,
    //           'stock' => 10 ,
    //           'code' => 'large' ,
    //           'sku' => 'large' ,
    //         ]
    //       ],
    //     ],
    //   ];
    // }
}
