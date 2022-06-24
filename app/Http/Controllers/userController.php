<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use DB;

class userController extends Controller
{
    public function index(){
        $users = User::all();
        return userResource::collection($users);
    }

    public function deleteAccount($id){

        $user = User::find(Auth::user()->id);
        // Auth::logout();
        $user = User::where('id',$user->id)->delete();
        return $this->successResponse([]);

    }
   
}
