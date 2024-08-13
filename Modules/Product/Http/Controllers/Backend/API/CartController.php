<?php

namespace Modules\Product\Http\Controllers\backend\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Models\Cart;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductVariation;
use Modules\Product\Transformers\CartResource;
use Modules\Product\Http\Requests\CartRequest;
use Auth;

class CartController extends Controller
{

    public function getCartList(Request $request)
    {
        $user_id=$request->input('user_id') ?? Auth::id();

        $perPage = $request->input('per_page', 10);

        $cart = Cart::where('user_id', $user_id)
        ->with('product', 'product_variation')
        ->whereHas('product', function ($query) {
            $query->whereNotNull('id'); 
        });

        $cart = $cart->paginate($perPage);

        $sumOfPrices = $cart->sum(function ($item) {
            if($item->product_variation){
                return optional($item->product_variation)->price * $item->qty;
            }
        });

        $discount_price=getDiscountAmount($cart);

        $tax_amount=$cart->isEmpty() ? null:getTaxamount($sumOfPrices-$discount_price);
        $total_payable_amount = $cart->isEmpty() ? 0 : ($sumOfPrices - $discount_price + $tax_amount['total_tax_amount']);

        $amount=[

            'tax_included_amount'=>$sumOfPrices,
            'discount_amount'=>$discount_price,
            'total_amount'=>$sumOfPrices-$discount_price,
            'tax_data'=> $tax_amount,
            'tax_amount'=>  $cart->isEmpty() ? 0 :$tax_amount['total_tax_amount'],
            'total_payable_amount'=>$total_payable_amount,
          
        ];
        
        $cartCollection = CartResource::collection($cart);

        return response()->json([
           'status' => true,
           'data' =>  $cartCollection,
           'price' => $amount,
           'message' => __('product.cart_list'),
        ], 200);
        
     }


    public function store(CartRequest $request)
    {
        $data=$request->all();

        $product=Product::where('id',$data['product_id'])->first();

       
        if(!$product){

             $message = __('product.product_not_found');

            return response()->json(['message' => $message,'status' => true], 200);

         }

        $data['user_id'] = $request->input('user_id') ?? Auth::id();

        $cart = Cart::Create($data);

        $cartCollection= new CartResource($cart);

        $message = __('product.added_into_cart');

        return response()->json(['message' => $message,'cart'=>$cartCollection,'status' => true], 200);
    
    }


    public function removeCart(Request $request)
    {
        $cart_id=$request->cart_id;

        $cart=Cart::where('id',$cart_id)->first();

        if(!$cart){

             $message = __('product.cart_not_found');

            return response()->json(['message' => $message,'status' => true], 200);

         }

         $cart->delete();



        $message = __('product.product_remove_from_cart');

        return response()->json(['message' => $message,'status' => true], 200);

    }

    public function  UpdateCart(CartRequest $request){
    
        $cart_id=$request->cart_id;
        $product_variation_id=$request->product_variation_id;
        $qty=$request->qty;

        $product_variation=ProductVariation::where('id',$product_variation_id)->first();

        if($product_variation){

           $get_total_stock=$product_variation->product_variation_stock->stock_qty;

           $cart_item = Cart::find($cart_id);

           if($qty>$get_total_stock){

              $message = 'Only ' . $get_total_stock . ' Quantity is available';

             return response()->json(['message' => $message,'status' => true], 200);

           }else if($qty<=$get_total_stock){

                $difference = $qty - $cart_item->qty;

                $cart_item->update(['qty' => $qty]);

                if ($difference > 0) {
                    $message = 'Quantity Added';
                } elseif ($difference < 0) {
                    $message = 'Quantity Removed';
                }

               return response()->json(['message' => $message,'status' => true], 200);
           
           }
        }
    }


}
