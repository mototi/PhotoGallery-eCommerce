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
    public function placeOrder()
    {
        $customer = auth()->user()->customer;

        $cart = $customer->product()->where('customer_id', $customer->id)->get();

        //return false if cart is empty
        if ($cart->isEmpty()) {
            return false;
        }

        //total price
        $total_price =  $cart->sum(function ($item) {
            return $item->price * $item->pivot->quantity;
        });

        foreach ($cart as $item) {
            if ($item->stock < $item->pivot->quantity) {
                return false;
            }
        }

        $order = Order::create([
            'customer_id' => $customer->id,
            'total_price' => $total_price,
            'status' => 'on it',
            'number' => rand(100000, 999999),
            'date' => now(),
        ]);

        $customer->product()->detach();

        return $order;

    }
}
