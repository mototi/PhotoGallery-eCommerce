<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Http\Requests\Products\CreateProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //create new product
    public function createProduct(CreateProductRequest $request)
    {
        $product = $request->createProduct();
        return new ProductResource($product);
    }

    //get product by id
    public function getSingleProduct($id)
    {
        $product = Product::with('admin')->findOrFail($id);
        return new ProductResource($product);
    }

    //get all products
    public function getAllProducts()
    {
        $products = Product::query();

        $products->with(['admin']);

        //filter by search
        if(request()->has('search') && request()->search != ''){
            $products->where('name', 'like', '%' . request()->search . '%');
        }

        //filter by category
        if(request()->has('category') && request()->category != ''){
            $products->where('category', 'like' , '%' . request()->category . '%');
        }

        //simple pabination
        $products = $products->simplePaginate(
            request()->per_page ?? 10 //default 10
        );

        return ProductResource::collection($products);
    }

    //delete product
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        //delete image from public/images/products
        $image_name = $product->image;
        File::delete(public_path() . "/images/products/" . $image_name);

        return response([
            'message' => 'product deleted successfully'
        ], 200);
    }

    //update product
    public function updateProduct(UpdateProductRequest $request)
    {
        $product = $request->putProduct();
        return new ProductResource($product);
    }

}
