<?php

namespace App\Http\Controllers;

use App\Http\Requests\Orders\PlaceOrderRequest;
use App\Http\Requests\Orders\AddProductToOrderRequest;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    //place order
    public function createOrder(PlaceOrderRequest $request)
    {
        $order = $request->placeOrder();

        if($order['status'] == false) {
            return response()->json([
                'message' => $order['message'],
            ], 400);
        }

        return response()->json([
            'message' => 'Order placed successfully',
            'order' => $order,
        ], 201);
    }

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
