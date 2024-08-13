<?php

namespace Modules\Product\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Models\Brands;
use Illuminate\Support\Arr;

class BrandsTableSeeder extends Seeder
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
                'name' => 'Sojoss',
                'feature_image' => public_path('/dummy-images/Brand/sojoss.png'),
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_by' => 1,
            ],
            [
                'name' => 'Droools',
                'feature_image' => public_path('/dummy-images/Brand/droools.png'),
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_by' => 1,
            ],
            [
                'name' => 'Loveeabowl',
                'feature_image' => public_path('/dummy-images/Brand/loveeabowl.png'),
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_by' => 1,
            ],
            [
                'name' => 'Hufft',
                'feature_image' => public_path('/dummy-images/Brand/hufft.png'),
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_by' => 1,
            ],
            [
                'name' => 'Pureepet',
                'feature_image' => public_path('/dummy-images/Brand/pureepet.png'),
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_by' => 1,
            ],
            [
                'name' => 'Feekoo',
                'feature_image' => public_path('/dummy-images/Brand/feekoo.png'),
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_by' => 1,
            ],
            [
                'name' => 'BirdiesNature',
                'feature_image' => public_path('/dummy-images/Brand/birdies_nature.png'),
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_by' => 1,
            ],
            [
                'name' => 'Vitaakraft',
                'feature_image' => public_path('/dummy-images/Brand/vitaakraft.png'),
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_by' => 1,
            ],
            [
                'name' => 'Puppteck',
                'feature_image' => public_path('/dummy-images/Brand/puppteck.png'),
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_by' => 1,
            ],
            [
                'name' => 'Senapatee',
                'feature_image' => public_path('/dummy-images/Brand/senapatee.png'),
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_by' => 1,
            ],
            [
                'name' => 'Thoor',
                'feature_image' => public_path('/dummy-images/Brand/thoor.png'),
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_by' => 1,
            ],
            [
                'name' => 'Kootkoot',
                'feature_image' => public_path('/dummy-images/Brand/kootkoot.png'),
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_by' => 1,
            ],
            [
                'name' => 'Xigweeg',
                'feature_image' => public_path('/dummy-images/Brand/xigweeg.png'),
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_by' => 1,
            ],
            [
                'name' => 'Vvjoy',
                'feature_image' => public_path('/dummy-images/Brand/vvjoy.png'),
                'updated_by' => 1,
                'deleted_by' => NULL,
                'created_by' => 1,
            ],
        ];

        if(env('IS_DUMMY_DATA')) {
            foreach ($data as $key => $value) {
                // Brands::create($value);
                $image = $value['feature_image'] ?? null;
                $brand = Arr::except($value, ['feature_image']);
                // $brand = [
                //     'name' => $value['name'],
                // ];
                $brand =Brands::create($brand);
                if (isset($image)) {
                    $this->attachFeatureImage($brand, $image);
                }
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
