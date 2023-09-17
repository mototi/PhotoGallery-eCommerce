<?php

namespace App\Http\Requests\Orders;


use App\Models\Product;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Cart;
use Illuminate\Foundation\Http\FormRequest;

class GetOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if(auth()->user()->isAdmin() || auth()->user()->isCustomer()) {
            return true;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'order_id' => 'required|integer|exists:orders,id',
        ];
    }

    /**
     * Get order
     */
    public function getOrder(): array
    {
        $order = Order::findOrFail($this->order_id);

        // admin is autharized to view all orders
        if(auth()->user()->isAdmin()) {
            return $this->getCustomerOrder($order);
        }

        $customer = auth()->user()-> customer;
        // customer is autharized to view only his orders
        if($order->customer_id != $customer->id) {
            return [
                'status' => false,
                'message' => 'You are not authorized to view this order',
            ];
        }
        return $this->getCustomerOrder($order);
    }

    /**
     * Get order
     */
    public function getCustomerOrder($order): array
    {
        $cart = Cart::findOrFail($order->cart_id);
        $customer = Customer::findOrFail($order->customer_id);

        $customer_details = [
            'name' => trim($customer->first_name . ' ' . $customer->last_name),
            'email' => $customer->user->email,
            'phone' => $customer->phone,
            'address' => $customer->address,
        ];

        $order_details = [
            'order_id' => $order->id,
            'number' => $order->number,
            'total_price' => $order->total_price,
            'satatus' => $order->status,
        ];

        $cart_details = $cart-> product()
            -> where('cart_id', $cart->id)
            ->get();

        $products = [];
         foreach ($cart_details as $item) {
            $product = Product::find($item->pivot->product_id);
            $product_details = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $item->pivot->price,
                'quantity' => $item->pivot->quantity,
            ];
            array_push($products, $product_details);
        }

        return [
            'customer_details' => $customer_details,
            'order_details' => $order_details,
            'products' => $products,
        ];
    }

}
