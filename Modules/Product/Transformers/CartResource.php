<?php

namespace Modules\Product\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;
use Carbon\Carbon;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

        $user = User::find($this->product->created_by);

        $today = Carbon::today();
        $discount_value = 0;
        if (optional($this->product)->discount_start_date && optional($this->product)->discount_end_date && $today->gte(Carbon::createFromTimestamp(optional($this->product)->discount_start_date)) &&
                    $today->lte(Carbon::createFromTimestamp(optional($this->product)->discount_end_date))) {
            $discount_value = optional($this->product)->discount_value;
        }
        else{
            $discount_value = 0;
        }

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,   
            'product_id' => $this->product_id,
            'product_variation_id' => $this->product_variation_id,
            'qty' => $this->qty,
            'unit_name'=>optional($this->product->unit)->name,
            'product_name'=>optional($this->product)->name,
            'product_image' => optional($this->product)->media->pluck('original_url')->first(),
            'product_description'=>optional($this->product)->short_description,
            'discount_value'=>$discount_value,
            'discount_type'=>optional($this->product)->discount_type,
            'product_variation'=>new ProductVariationResource($this->product_variation),
            'product_variation_type' =>optional(optional(optional($this->product_variation)->combination)->variation_combination_data)->name ?? null,
            'product_variation_name' => optional(optional(optional($this->product_variation)->combination)->variation_combination_value)->name ?? null,
            'product_variation_value' => optional(optional(optional($this->product_variation)->combination)->variation_combination_value)->value ?? null,
            'sold_by'=>$user ? $user->first_name . ' ' . $user->last_name : 'Unknown',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
