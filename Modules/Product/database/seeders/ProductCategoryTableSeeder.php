<?php

namespace Modules\Product\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Models\ProductCategory;
use Illuminate\Support\Arr;

class ProductCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $data = [
        [
          'name' => 'Food and Treats',
          'feature_image' => public_path('/dummy-images/category-images/food_and_treats.png'),
          'sub_category' => [
              [
                'name' => 'Dog & Cat Supplies',
                'status' => 1,
                'feature_image' => public_path('/dummy-images/subcategory-images/dog_cat_supplies.png'),

              ],
              [
                'name' => 'Bird, Fish & Small Animal Supplies',
                'status' => 1,
                'feature_image' => public_path('/dummy-images/subcategory-images/bird_fish_small_animal.png'),
              ],
              [
                'name' => 'Reptile Supplies',
                'status' => 1,
                'feature_image' => public_path('/dummy-images/subcategory-images/reptile_supplies.png'),
              ],
          ],
        ],
        [
          'name' => 'Collars, Leashes, and Harnesses',
          'feature_image' => public_path('/dummy-images/category-images/collars_leashes_and_harnesses.png'),
          'sub_category' => [
              [
                'name' => 'Collars',
                'status' => 1,
                'feature_image' => public_path('/dummy-images/subcategory-images/collars.png'),

              ],
              [
                'name' => 'Leashes',
                'status' => 1,
                'feature_image' => public_path('/dummy-images/subcategory-images/leashes.png'),
              ],
          ],
        ],
        [
          'name' => 'Custom and Fashion Accessories',
          'feature_image' => public_path('/dummy-images/category-images/custom_and_fashion_accessories.png'),
          'sub_category' => [],
        ],
        [
          'name' => 'Beds and Bedding',
          'feature_image' => public_path('/dummy-images/category-images/beds_and_bedding.png'),
          'sub_category' => [],
        ],
        [
          'name' => 'Toys',
          'feature_image' => public_path('/dummy-images/category-images/toys.png'),
          'sub_category' => [],
        ],
        [
          'name' => 'Clothing & Accessories',
          'feature_image' => public_path('/dummy-images/category-images/clothing_accessories.png'),
          'sub_category' => [],
        ],
        [
          'name' => 'Health and Wellness Products',
          'feature_image' => public_path('/dummy-images/category-images/health_and_wellness_products.png'),
          'sub_category' => [],
        ],
        [
          'name' => 'Grooming Products',
          'feature_image' => public_path('/dummy-images/category-images/grooming_products.png'),
          'sub_category' => [],
        ],
      ];
      if(env('IS_DUMMY_DATA')) {
        foreach ($data as $key => $value) {
          // $query = ProductCategory::create($value);
          // $query->brands()->sync([1,2,3,4,5,6,7,8,9,10,11,12,13,14]);

          $subCategorys = $value['sub_category'];
          $image = $value['feature_image'] ?? null;
          $product_category = Arr::except($value, ['feature_image']);
          $product_category = [
            'name' => $value['name'],
          ];
          $product_category = ProductCategory::create($product_category);
          if (isset($image)) {
            $this->attachFeatureImage($product_category, $image);
          }
          foreach ($subCategorys as $subKey => $subCategory) {
              $subCategory['parent_id'] = $product_category->id;
              $featureImage = $subCategory['feature_image'] ?? null;
              $sub_categoryData = Arr::except($subCategory, ['feature_image']);
              $subcategoryData = ProductCategory::create($sub_categoryData);
              if (isset($featureImage)) {
                  $this->attachFeatureImage($subcategoryData, $featureImage);
              }
          }

          // $product_category->brands()->sync([1,2,3,4,5,6,7,8,9,10,11,12,13,14]);
        }
      }
    }

    private function attachFeatureImage($model, $publicPath)
    {
        if(!env('IS_DUMMY_DATA_IMAGE')) return false;

        $file = new \Illuminate\Http\File($publicPath);

        $media = $model->addMedia($file)->preservingOriginal()->toMediaCollection('feature_image');

        return $media;
    }
}
