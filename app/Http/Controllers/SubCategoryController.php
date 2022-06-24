<?php

namespace App\Http\Controllers;

use App\Models\Sub_Category;
use App\Models\Category;
use App\http\Resources\SubCategoryResource;

class SubCategoryController extends Controller
{

    public function index(){
       $categories=Sub_Category::all();
       return SubCategoryResource::collection($categories)->hide(['stores']);
   }

    public function getStoreBySubCategory($id){
        $sub = Sub_Category::where('id',$id)->get();//return $sub;
        return SubCategoryResource::collection( $sub );
    }

   
}
