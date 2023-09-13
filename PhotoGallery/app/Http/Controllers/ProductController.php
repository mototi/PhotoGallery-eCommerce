<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Resources\ProductResource;
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
        $products = Product::with('admin')->get();
        return ProductResource::collection($products);
    }

}
