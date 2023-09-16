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
        return true;
        //return auth()->user()->isCustomer();
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
    public function addProductToOrder(): void
    {
        $product = Product::findOrFail($this->product_id);
        $price = $product->price;

        //check if yhe quantity is available
        if ($product->stock < $this->quantity) {
            abort(400, 'The quantity you requested is not available');
        }

        $customer = Customer::where('user_id', auth()->user()->id)->first();

        $customer -> product() -> attach($product->id, [
            'quantity' => $this->quantity,
            'price' => $price,
        ]);
    }
}
