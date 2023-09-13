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
        'prefix' => 'v1',
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
                Route::post('/create', 'ProductController@createProduct');
                // get all products route
                Route::get('/', 'ProductController@getAllProducts');
                // get single product route
                Route::get('/{id}', 'ProductController@getSingleProduct');
                // update product route
                Route::put('/', 'ProductController@updateProduct');
                // delete product route
                Route::delete('/{id}', 'ProductController@deleteProduct')->middleware('admin');
            }
        );

    }
);
