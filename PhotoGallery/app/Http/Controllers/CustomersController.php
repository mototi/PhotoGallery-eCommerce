<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Resources\CustomerResource;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    // get all customers with pagination
    public function getAllCustomers(){

        //simplePagination with 10 items per page
        $customers = Customer::simplePaginate(
            request()->per_page ?? 10
        );

        return response()->json([
            'message' => 'All customers fetched successfully',
            'data' => CustomerResource::collection($customers)
        ]);
    }

    // get single customer
    public function getSingleCustomer($id){
        $customer = Customer::find($id);
        if(!$customer){
            return response()->json([
                'message' => 'Customer not found',
                'data' => null
            ]);
        }
        return response()->json([
            'message' => 'Customer fetched successfully',
            'data' => new CustomerResource($customer)
        ]);
    }
}
