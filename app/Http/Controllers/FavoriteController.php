<?php

namespace App\Http\Controllers;

use App\http\Resources\ProductResource;
use App\http\Resources\FavoriteResource;
use App\Models\Product;
use App\Models\Favorite;
use Auth;
use DB;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Favorite::where('user_id', Auth::id())->join('products', 'products.id', '=', 'favorite.product_id')
        ->select('products.*')->get();
        return $this->successResponse($favorites);
    }

    public function AddtoFavorite($id)
    {
        $product = Product::findOrFail($id);
        $favorite = DB::table('favorite')->where('user_id', Auth::id())->where('product_id', $id)->first();
        if ($favorite) {
            return $this->successResponse([]);

        } else {
            $fav = DB::insert('INSERT INTO favorite (user_id, product_id) VALUES (?, ?)', [Auth::id(), $id]);
            return $this->successResponse([]);
        }

    }

    public function removeFromFavorite($id)
    {
        $product = Product::findOrFail($id);
        $favorite = DB::table('favorite')->where('user_id', Auth::id())
        ->where('product_id', $id)
        ->delete();
        return $this->successResponse([]);
    }
}
