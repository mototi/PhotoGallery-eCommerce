<?php

namespace App\Http\Requests\Orders;

use App\Models\Customer;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class AddProductToOrderRequest extends FormRequest
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
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    /**
     * add product to order
     */
    public function addProductToOrder(): bool
    {
        $product = Product::findOrFail($this->product_id);
        $price = $product->price;

        //check if yhe quantity is available
        if ($product->stock < $this->quantity) {
            return false;
        }

        $customer = Customer::where('user_id', auth()->user()->id)->first();

        // get the id of customer's cart that has the biggist id
        $cart = $customer->cart()->orderBy('id', 'desc')->first();


        $cart -> product() -> attach($product->id, [
            'quantity' => $this->quantity,
            'price' => $price,
        ]);


        return true;
    }

}
