<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\product;
use App\Models\Store;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ColorResource;
use App\Http\Resources\SizeResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function getProducts($sub_id, $store_id)
    {
        $products = product::where('subcategory_id', $sub_id)
            ->where('store_id', $store_id)
            ->orderBy('id', 'Desc')->get();
        return $this->successResponse(ProductResource::collection($products));
    }

    public function getstoreProducts($store_id)
    {
        $products = product::where('store_id', $store_id)
            ->orderBy('id', 'Desc')->get();
        return $this->successResponse(ProductResource::collection($products));
    }


    public function show($id)
    {
        $product = product::findOrFail($id);
        return $this->successResponse(ProductResource::make($product));
    }

    public function index()
    {

        $products = product::all();
        // $products = product::with('sizes')->get();
        return ProductResource::collection($products)
        ;
    }

    public function getproduct($id)
    {

        $product = product::findOrFail($id);
       return  response([
        "id"=>$product->id,
        "name"=>$product->name,
        "price"=>$product->price,
        "description"=>$product->description,
        "image"=>url($product->image),
        "color"=>ColorResource::collection($product->colors),
        "size"=>SizeResource::collection($product->sizes)
       ], 200);
      
    }
    public function searchProductbyName(Request $request)
    {
        // $validatedData = $request->validate([
        //     's' => 'required',
        // ]);
        $products = Product::where('name', 'like', "%{$request->s}%")->get();
        if ($products->isEmpty() || !$request->s ) {
            return $this->errorResponse([]);
        } else {
            return $this->successResponse(ProductResource::collection($products));
        }

    }

    public function recommendation(){
        $products= Product::join('favorite','products.id','product_id')
        ->where('favorite.user_id',Auth::id())->select('subcategory_id')->get();
        $subcategorie_ids = [];
        foreach($products as $prod){
            array_push($subcategorie_ids, $prod->subcategory_id);
        }
        $rec = Product::inRandomOrder()->whereIn('subcategory_id',$subcategorie_ids)->take(4)->get();
        return $this->successResponse(ProductResource::collection($rec));
    }

    public function store(Request $request){
        $store= Store::where('user_id',Auth::id())->first();
        $product = new Product();
        $destinationPath = 'image/';
        $profileImage = date('YmdHis') . "." . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->move($destinationPath, $profileImage);
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->image = $destinationPath.date('YmdHis.').$request->file('image')->getClientOriginalExtension();
        $product->price = $request->input('price');
        $product->discount = $request->input('discount');
        $product->store_id = $store->id;
        $product->category_id = $request->input('category_id');
        $product->subcategory_id = $request->input('subcategory_id');
        $product->save();
        return $product;
    }

    public function deleteProduct($id){
        $store= Store::where('user_id',Auth::id())->first();
        $product = Product::where('id',$id)->where('store_id',$store->id);
        $product->delete();
        return $this->successResponse([]);
    }

}
