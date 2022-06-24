<?php

namespace App\Http\Controllers;

use App\Http\Resources\StoreResource;
use App\Models\Store;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Validator;
class StoreController extends Controller
{
    public function index(){
        $stores=Store::all();
        return $this->successResponse(StoreResource::collection($stores));
    }

    public function storeLocation($store_id){
        $latitude=Store::where('store_id', $store_id)->select('latitude')->get();
        $longitude=Store::where('store_id', $store_id)->select('longitude')->get();
        return response(['latitude'=>$latitude,'longitude'=>$longitude],200);
    }
    // getstoreProducts
    public function getstoreProducts($id){
        $subb = Product::where('store_id',$id)->get();
        return $this->successResponse(StoreResource::collection($subb));
        // return $subb;
    }
    public function getstoreProductscount($id){
        $subb = Product::where('store_id',$id)->count();
        // return $this->successResponse(StoreResource::collection($subb));
        return $subb;
    }


    public function searchStorebyName(Request $request)
    {      
        $stores = Store::where('name', 'like', "%{$request->s}%")->get();
        if ($stores->isEmpty() ) {
            return $this->successResponse([]);
        } else {
            return $this->successResponse(StoreResource::collection($stores));
        }
    }
    
    public function createStore(Request $request){
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required',
        //     'email' => 'required|email',
        //     'password' => 'required',
        //     'confirm_password' => 'required|same:password',
        // ]);
   
        // if($validator->fails()){
        //     return $this->sendError('Error validation', $validator->errors());       
        // }
   
        $user = new User();
        $input = $request->all();
        $input['password'] =  bcrypt($request->input('password'));
        $input['type'] = 1;
        $user = User::create($input);
        $store = new Store();
        $destinationPath = 'image/';
        $profileImage = date('YmdHis') . "." . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->move($destinationPath, $profileImage);
        $store->user_id = $user->id;
        $store->name = $request->input('bussinessname');
        $store->description = $request->input('description');
        $store->image = $destinationPath.date('YmdHis.').$request->file('image')->getClientOriginalExtension();
        $store->location = $request->input('location');
        $store->latitude = $request->input('latitude');
        $store->longitude = $request->input('longitude');
        $store->open_state = $request->input('open_state');
        $store->save();
        $success['token'] =  $user->createToken('MyAuthApp')->plainTextToken;
        $success['name'] =  $store->name;
        $success['image']=url($store->image);   
        return $this->successResponse($success, 'User created successfully.');
    }
}