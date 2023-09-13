<?php

namespace App\Http\Requests\Products;


use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //role admin only
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
            "admin_id" => "required|integer|exists:admins,id",
            "name" => "required|string",
            "description" => "string|max:5000",
            "price" => "required|numeric",
            "image" => "required|image|",
            "category" => "string|max:255",
            "stock" => "integer",
        ];
    }

    /**
     * create new product
     */
    public function createProduct(): Product
    {
        //get file extention of image
        $file_extension = $this->image->getClientOriginalExtension();
        $file_name = time() . "." . $file_extension;
        $path = "images/products/" ;

        $this -> image -> move($path, $file_name);

        $product = Product::create([
            "admin_id" => $this->admin_id,
            "name" => $this->name,
            "description" => $this->description,
            "price" => $this->price,
            "image" => $file_name,
            "category" => $this->category,
            "stock" => $this->stock,
        ]);

        return $product -> makeHidden(["created_at", "updated_at"]);
    }
}
