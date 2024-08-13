<?php

namespace Modules\Product\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\User;



class ProductDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $user = User::find($this->created_by);
        $gallry = $this->gallery()->get()->pluck('full_url')->toArray();

        array_unshift($gallry, $this->feature_image);

        $today = Carbon::today();
        $discount_value = 0;
        if ($this->discount_start_date && $this->discount_end_date && $today->gte(Carbon::createFromTimestamp($this->discount_start_date)) &&
                    $today->lte(Carbon::createFromTimestamp($this->discount_end_date))) {
            $discount_value = $this->discount_value;
        }
        else{
            $discount_value = 0;
        }
       
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'product_image' => $this->feature_image,
            'category' =>ProductCategoryResource::collection($this->categories),
            'brand_id'=>$this->brand_id,
            'brand_name'=> optional($this->brand)->name,
            'brand_image' => $this->brand ? $this->brand->media->pluck('original_url')->first() : null,  
            'unit_id'=>$this->unit_id,
            'unit_name'=>optional($this->unit)->name,
            'short_description' => $this->short_description ? $this->short_description : null,
            'description' => $this->description ? $this->description : null,
            'min_price' =>$this->min_price,
            'max_price' => $this->max_price,
            'discount_value' => $discount_value,
            'discount_type'=>$this->discount_type,
            'min_discounted_product_amount' => getDiscountedProductPrice($this->min_price,$this->id),
            'max_discounted_product_amount' => getDiscountedProductPrice($this->max_price,$this->id),
            'discount_start_date' => $this->discount_start_date ? Carbon::createFromTimestamp($this->discount_start_date)->format('Y-m-d') : null,
            'discount_end_date' => $this->discount_end_date ? Carbon::createFromTimestamp($this->discount_end_date)->format('Y-m-d') : null,
            'sell_target' => $this->sell_target,
            'stock_qty' => $this->stock_qty,
            'status'=> $this->status,
            'min_purchase_qty'=>$this->min_purchase_qty,
            'has_variation'=>$this->has_variation,
            'product_gallary'=>$gallry,
            'variation_data'=> ProductVariationResource::collection($this->product_variations),
            'in_wishlist' => $request->has('user_id') ? checkInWishList($this->id, $request->input('user_id')) : 0,
            'has_warranty'=>$this->has_warranty,
            'rating_count'=> Count($this->product_review),
            'rating' => Count($this->product_review) > 0 ? $this->product_review->sum('rating') / Count($this->product_review) : 0,
            'product_review'=>ReviewResource::collection($this->product_review),
            'is_featured' => $this->is_featured,
            'product_tags' => $this->tags_data->pluck('name')->toArray(),
            'date_range' => ($this->discount_start_date !== null && $this->discount_end_date !== null) ? date('Y-m-d', $this->discount_start_date) . ' to ' . date('Y-m-d', $this->discount_end_date) : null,
            'sold_by'=>$user ? $user->first_name . ' ' . $user->last_name : 'Unknown',
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
