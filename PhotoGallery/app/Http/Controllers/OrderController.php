<?php

namespace App\Http\Controllers;


use App\Models\Order;
use App\Http\Requests\Orders\GetOrderRequest;
use App\Http\Requests\Orders\UpdateStatusRequest;
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

    //remove product from order
    public function removeProductFromCart(AddProductToOrderRequest $request)
    {
        $request->removeProductFromOrder();

        return response()->json([
            'message' => 'Product removed from cart successfully',
        ], 200);
    }

    //update product quantity in order
    public function updateProductQuantityInCart(AddProductToOrderRequest $request)
    {
        $request = $request->changeProductQuantityInOrder();

        if (!$request) {
            return response()->json([
                'message' => 'qantity not available',
            ], 400);
        }

        return response()->json([
            'message' => 'Product quantity updated successfully',
        ], 200);
    }

    //get order
    public function getOrder(GetOrderRequest $request)
    {
        $order = $request->getOrder();

        if($order['status'] == false) {
            return response()->json([
                'status' => false,
                'message' => $order['message'],
            ], 400);
        }

        return response()->json( $order , 200);
    }

    //get all order
    public function getAllOrders()
    {
        $orders = Order::query();

        // number fillter
        if (request()->has('number') && request()->number != '') {
            $orders->where('number', 'like', '%' . request()->number . '%');
        }

        // simple pagination
        $orders = $orders->simplePaginate(
            request()->per_page ?? 15 // default 10
        );

        return response()->json([
            'orders' => $orders,
        ], 200);
    }

    //get single order
    public function getSingleOrder($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'message' => 'Order not found',
            ], 404);
        }

        return response()->json([
            'order' => $order,
        ], 200);
    }

    //update order status
    public function updateOrderStatus(UpdateStatusRequest $request)
    {
        $order = $request->updateOrder();

        return response()->json([
            'message' => 'Order status updated successfully',
            'order' => $order,
        ], 200);
    }

}
