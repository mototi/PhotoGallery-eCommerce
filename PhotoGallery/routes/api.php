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

    }
);
