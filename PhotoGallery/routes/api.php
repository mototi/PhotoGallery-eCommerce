<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::group(
    [
        'prefix' => 'dashboard',
        'namespace' => 'App\Http\Controllers',
    ],
    function (){
        // group auth routes
        Route::group(
            [
                'prefix' => 'auth'
            ],
            function (){
                // register route
                Route::post('/register', 'AuthController@register');
                // login route
                Route::post('/login', 'AuthController@login');
                // logout route
                Route::post('/logout', 'AuthController@logout')->middleware('auth:sanctum');
            }
        );

        // group product routes
        Route::group(
            [
                'prefix' => 'products',
                'middleware' => 'auth:sanctum'
            ],
            function (){
                // create product route
                Route::post('/create', 'ProductController@createProduct')->middleware('admin');
                // get all products route
                Route::get('/', 'ProductController@getAllProducts')->middleware('admin');
                // get single product route
                Route::get('/{id}', 'ProductController@getSingleProduct')->middleware('admin');
                // update product route
                Route::put('/', 'ProductController@updateProduct')->middleware('admin');
                // delete product route
                Route::delete('/{id}', 'ProductController@deleteProduct')->middleware('admin');
            }
        );

        // group customer routes
        Route::group(
            [
                'prefix' => 'customers',
                'middleware' => 'auth:sanctum'
            ],
            function (){
                // get all customers route
                Route::get('/', 'CustomersController@getAllCustomers')->middleware('admin');
                // get single customer route
                Route::get('/{id}', 'CustomersController@getSingleCustomer')->middleware('admin');
            }
        );

        // group order routes
        Route::group(
            [
                'prefix' => 'orders',
                'middleware' => 'auth:sanctum'
            ],
            function (){
                // get all orders route
                Route::get('/all', 'OrderController@getAllOrders')->middleware('admin');
                // get single order route
                Route::get('/{id}', 'OrderController@getSingleOrder')->middleware('admin');
                // get order route
                Route::get('/', 'OrderController@getOrder')->middleware('admin');
                // update order status route
                Route::put('/update-status', 'OrderController@updateOrderStatus')->middleware('admin');

            }
        );

    }
);

// landing page
Route::group(
    [
        'prefix' => 'website',
        'namespace' => 'App\Http\Controllers',
    ],
    function (){
        // group auth routes
        Route::group(
            [
                'prefix' => 'auth'
            ],
            function (){
                // register route
                Route::post('/register', 'AuthController@customerRegister');
                // login route
                Route::post('/login', 'AuthController@login');
                // logout route
                Route::post('/logout', 'AuthController@logout')->middleware('auth:sanctum');
            }
        );

        // group product routes
        Route::group(
            [
                'prefix' => 'products',
                "middleware" => "auth:sanctum",
            ],
            function (){
                // get all products route
                Route::get('/', 'ProductController@getAllProducts');
                // get single product route
                Route::get('/{id}', 'ProductController@getSingleProduct');
            }
        );
        // group profile routes
        Route::group(
            [
                'prefix' => 'profile',
                "middleware" => "auth:sanctum",
            ],
            function (){
                // get customer's own profile route
                Route::get('/', 'CustomersController@getCustomerProfile');
            }
        );

        // group order routes
        Route::group(
            [
                'prefix' => 'orders',
                "middleware" => "auth:sanctum",
            ],
            function (){
                // create order route
                Route::post('/create', 'OrderController@createOrder');
                // add product to order route
                Route::post('/add-product', 'OrderController@addProductToCart');

                // remove product from order route
                Route::delete('/remove-product', 'OrderController@removeProductFromCart');

                // update product quantity in order route
                Route::put('/update-product-quantity', 'OrderController@updateProductQuantityInCart');

                // get order route
                Route::get('/', 'OrderController@getOrder');
            }
        );
    }
);
