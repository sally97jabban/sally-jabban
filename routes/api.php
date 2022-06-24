<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\userController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', [AuthController::class, 'signin']);
Route::post('register', [AuthController::class, 'signup']);
Route::post('auth/facebook', [AuthController::class, 'facebook']);
Route::post('auth/google', [AuthController::class, 'google']);
Route::middleware('auth:sanctum')->group(function () {
Route::post('addorder',[OrderController::class,'addOrder']);
Route::get('getfavorite',[FavoriteController::class,'index']);
Route::post('addfavorite/{id}',[FavoriteController::class,'AddtoFavorite']);
Route::delete('deletefavorite/{id}',[FavoriteController::class,'removeFromFavorite']);
Route::get('product/search',[ProductController::class,'searchProductbyName']);
Route::get('store/search',[StoreController::class,'searchStorebyName']);
Route::get('order',[OrderController::class,'index']);
Route::get('recommendation',[ProductController::class,'recommendation']);
Route::post('createproduct',[ProductController::class,'store']);
Route::delete('deleteproduct/{id}',[ProductController::class,'deleteProduct']);
Route::get('getstoreProducts/{id}',[StoreController::class,'getstoreProducts']);
Route::get('getstoreProductscount/{id}',[StoreController::class,'getstoreProductscount']);
// Route::get('storeorders/{id}',[OrderController::class,'allOrdersBystore']);
Route::delete('deleteAccount/{id}',[userController::class,'deleteAccount']);
Route::get('allOrdersBystore/{id}',[OrderController::class,'allOrdersBystore']);

});

Route::get('category',[CategoryController::class,'index']);
Route::get('store',[StoreController::class,'index']);
Route::get('subcategory/{id}/store',[SubCategoryController::class,'getStoreBySubCategory']);
Route::get('subcat/{sub_id}/store/{store_id}/products',[ProductController::class,'getProducts']);
Route::get('store/{store_id}/products',[ProductController::class,'getstoreProducts']);
Route::get('product/{id}',[ProductController::class,'show']);
Route::get('getproduct/{id}',[ProductController::class,'getproduct']);
Route::get('product',[ProductController::class,'index']);
Route::get('SubCategory',[SubCategoryController::class,'index']);
// Route::post('addfavorite/{id}',[FavoriteController::class,'AddtoFavorite']);
// Route::get('favorit',[FavoriteController::class,'index']);
Route::get('getStatus/{id}',[OrderController::class,'orderStatus']);
Route::post('createStore',[StoreController::class,'createStore']);



