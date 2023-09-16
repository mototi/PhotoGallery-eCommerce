<?php

namespace App\Http\Controllers;

use App\Http\Requests\Orders\AddProductToOrderRequest;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    //add product to order
    public function addProductToCart(AddProductToOrderRequest $request)
    {
        if (!$request->addProductToOrder()) {
            return response()->json([
                'message' => 'qantity not available',
            ], 400);
        }

        return response ()->json([
            'message' => 'Product added to cart successfully',
        ], 201);
    }
}
