<?php

namespace App\Http\Requests\Orders;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class PlaceOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->isCustomer();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }

    //place order
    public function placeOrder() : array
    {
        $customer = auth()->user()->customer;

        //get the id of customer's cart that has the biggist id
        $cart = $customer->cart()->orderBy('id', 'desc')->first();

        $cartProducts;

        try{
           $cartProducts = $cart->product()->where('cart_id', $cart->id)->get();
        }catch(\Exception $e){
            return [
                'status' => false,
                'message' => 'cart is empty',
            ];
        }


        // begin transaction
        DB::beginTransaction();
        try{

            // check if the quantity of the products in the cart is available
            foreach ($cartProducts as $item) {
                $product = Product::findOrFail($item->product_id);
                if ($product->stock < $item->quantity) {
                    return [
                        'status' => false,
                        'message' => 'product ' . $product->name . ' is not available with this quantity',
                    ];
                }
                //update the stock of the product
                $product->update([
                    'stock' => $product->stock - $item->quantity,
                ]);
            }

            // total_price of the cart
            $totalPrice = $cartProducts->sum(function ($product) {
                return $product->quantity * $product->price;
            });

            // update the total_price of the cart
            $cart->update([
                'total_price' => $totalPrice,
            ]);

            // create order
            $order = Order::create([
                'customer_id' => $customer->id,
                'total_price' => $totalPrice,
                'number' => rand(100000, 999999),
                'cart_id' => $cart->id,
            ]);

            // save transaction
            DB::commit();

            return [
                'status' => true,
                'message' => 'order placed successfully',
                'order' => $order,
            ];


        }catch(\Exception $e){
            DB::rollback();
            return [
                'status' => false,
                'message' => 'something went wrong',
            ];
        }

    }
}
