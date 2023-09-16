<?php

namespace App\Http\Controllers;

use App\Http\Requests\Orders\AddProductToOrderRequest;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    //add product to order
    public function addProductToCart(AddProductToOrderRequest $request)
    {
        $request->addProductToOrder();

        return response ()->json([
            'message' => 'Product added to cart successfully',
        ], 201);
    }
}
