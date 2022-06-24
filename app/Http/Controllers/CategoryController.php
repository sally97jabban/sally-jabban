<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\SubCategoryResource;

class CategoryController extends Controller
{
   public function index(){
       $categories=Category::all();
       return CategoryResource::collection($categories)->hide(['stores']);
   }

   public function getSubCategoryByMainCategory($id){
    $subb = Category::where('id',$id)->with('sub_categories')->get();
    return $subb;
}
   
  
}
