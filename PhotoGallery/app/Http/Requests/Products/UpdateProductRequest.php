<?php

namespace App\Http\Requests\Products;

use Illuminate\Support\Facades\File;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|exists:products,id',
            'admin_id' => 'required|exists:admins,id',
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|image',
            'category' => 'required|string',
            'stock' => 'required|numeric',
        ];
    }

    /*
    * update product
    */
    public function putProduct(): Product
    {
        $product = Product::findOrFail($this->id);

        $product->update([
            'admin_id' => $this->admin_id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'category' => $this->category,
            'stock' => $this->stock,
        ]);

        //delete old image from public/images/products
        $image_name = $product->image;
        File::delete(public_path() . "/images/products/" . $image_name);

        //save new image
        $image = $this->file('image');
        $image_name = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/products'), $image_name);

        $product->update([
            'image' => $image_name
        ]);

        return $product;
    }

}
