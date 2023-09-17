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

        /**
         * if the cart has total price  that means that this customer already has order and we need to create new cart
         */
        if ($cart -> total_price != 0) {
            $cart = $customer->cart()->create();
        }

        try{
            $cart -> product() -> attach($product->id, [
                'quantity' => $this->quantity,
                'price' => $price,
            ]);
        }catch (\Exception $e){
            // if the product is already in the cart
            $cart->product()->updateExistingPivot($product->id, [
                'quantity' => $this->quantity,
            ]);
        }

        return true;
    }

    // remove product from order
    public function removeProductFromOrder(): bool
    {
        $product = Product::findOrFail($this->product_id);

        $customer = Customer::where('user_id', auth()->user()->id)->first();

        // get the id of customer's cart that has the biggist id
        $cart = $customer->cart()->orderBy('id', 'desc')->first();

        $cart->product()->detach($product->id);

        return true;
    }

    // change product quantity in order
    public function changeProductQuantityInOrder(): bool
    {
        $product = Product::findOrFail($this->product_id);

        // check if the quantity is available
        if ($product->stock < $this->quantity) {
            return false;
        }

        $customer = Customer::where('user_id', auth()->user()->id)->first();

        // get the id of customer's cart that has the biggist id
        $cart = $customer->cart()->orderBy('id', 'desc')->first();

        $cart->product()->updateExistingPivot($product->id, [
            'quantity' => $this->quantity,
        ]);

        return true;
    }

}
