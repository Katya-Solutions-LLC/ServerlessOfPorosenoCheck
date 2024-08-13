<?php

namespace Modules\Category\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Modules\Category\Models\Category;

class CategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env('IS_DUMMY_DATA')) {
            $data = [
               
                [
                    'slug' => 'general-veterinary-care',
                    'name' => 'General Veterinary Care',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/veterinary-cat/general_veterinary_care.png'),
                    'type' => 'veterinary'
                ],
                [
                    'slug' => 'emergency-and-critical-care',
                    'name' => 'Emergency and Critical Care',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/veterinary-cat/emergency_and_critical_care.png'),
                    'type' => 'veterinary'
                ],
                [
                    'slug' => 'surgery',
                    'name' => 'Surgery',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/veterinary-cat/surgery.png'),
                    'type' => 'veterinary'
                ],
                [
                    'slug' => 'dentistry',
                    'name' => 'Dentistry',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/veterinary-cat/dentistry.png'),
                    'type' => 'veterinary'
                ],
                [
                    'slug' => 'ophthalmology',
                    'name' => 'Ophthalmology',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/veterinary-cat/ophthalmology.png'),
                    'type' => 'veterinary'
                ],
                [
                    'slug' => 'cardiology',
                    'name' => 'Cardiology',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/veterinary-cat/cardiology.png'),
                    'type' => 'veterinary'
                ],
                [
                    'slug' => 'neurology',
                    'name' => 'Neurology',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/veterinary-cat/neurology.png'),
                    'type' => 'veterinary'
                ],
                [
                    'slug' => 'reproductive-medicine',
                    'name' => 'Reproductive Medicine',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/veterinary-cat/reproductive_medicine.png'),
                    'type' => 'veterinary'
                ],
                [
                    'slug' => 'radiology-and-imaging',
                    'name' => 'Radiology and Imaging',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/veterinary-cat/radiology_and_imaging.png'),
                    'type' => 'veterinary'
                ],
              
                


                // grooming category


                [
                    'slug' => 'bathing-and-shampooing',
                    'name' => 'Bathing and Shampooing',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/grooming-cat/bathing-and-shampooing.png'),
                    'type' => 'grooming'
                ],
                [
                    'slug' => 'hair-trimming-and-styling',
                    'name' => 'Hair Trimming and Styling',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/grooming-cat/hair-trimming-and-styling.png'),
                    'type' => 'grooming'
                ],
                [
                    'slug' => 'nail-trimming',
                    'name' => 'Nail Trimming',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/grooming-cat/nail-trimming.png'),
                    'type' => 'grooming'
                ],
                [
                    'slug' => 'ear-cleaning',
                    'name' => 'Ear Cleaning',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/grooming-cat/ear-cleaning.png'),
                    'type' => 'grooming'
                ],
                [
                    'slug' => 'brushing-and-de-Shedding',
                    'name' => 'Brushing and De-Shedding',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/grooming-cat/brushing-and-de-Shedding.png'),
                    'type' => 'grooming'
                ],
                [
                    'slug' => 'paw-pad-care',
                    'name' => 'Paw Pad Care',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/grooming-cat/paw-pad-care.png'),
                    'type' => 'grooming'
                ],
                [
                    'slug' => 'fur-coloring',
                    'name' => 'Fur Coloring',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/grooming-cat/fur-coloring.jpg'),
                    'type' => 'grooming'
                ],
                [
                    'slug' => 'massage-therapy',
                    'name' => 'Massage Therapy',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/grooming-cat/massage-therapy.png'),
                    'type' => 'grooming'
                ],
                [
                    'slug' => 'creative-grooming',
                    'name' => 'Creative Grooming',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/grooming-cat/creative-grooming.png'),
                    'type' => 'grooming'
                ],
                [
                    'slug' => 'video-consultancy',
                    'name' => 'Video Consultancy',
                    'status' => 1,
                    'feature_image' => public_path('/dummy-images/grooming-cat/creative-grooming.png'),
                    'type' => 'video-consultancy'
                ]
            ];
            foreach ($data as $key => $val) {
                // $subCategorys = $val['sub_category'];
                $featureImage = $val['feature_image'] ?? null;
                $categoryData = Arr::except($val, ['sub_category', 'feature_image']);
                $category = Category::create($categoryData);
                if (isset($featureImage)) {
                    $this->attachFeatureImage($category, $featureImage);
                }
                if(!empty($subCategorys)){
                    foreach ($subCategorys as $subKey => $subCategory) {
                        $subCategory['parent_id'] = $category->id;
                        $featureImage = $subCategory['feature_image'] ?? null;
                        $sub_categoryData = Arr::except($subCategory, ['feature_image']);
                        $subcategoryData = Category::create($sub_categoryData);
                        if (isset($featureImage)) {
                            $this->attachFeatureImage($subcategoryData, $featureImage);
                        }
                    }
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
