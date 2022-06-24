<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Auth;

class AuthController extends Controller
{
    public function signin(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $authUser = Auth::user(); 
            $success['token'] =  $authUser->createToken('MyAuthApp')->plainTextToken; 
            $success['name'] =  $authUser->name;
   
            return $this->successResponse($success, 'User signed in');
        } 
        else{ 
            return $this->errorResponse('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->errorResponse('Error validation', $validator->errors());       
        }

        $destinationPath = 'image/';
        $profileImage = date('YmdHis') . "." . $request->file('avatar')->getClientOriginalExtension();
        $request->file('avatar')->move($destinationPath, $profileImage);


        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['type'] = 0;
        $input['avatar'] = $destinationPath.date('YmdHis.').$request->file('avatar')->getClientOriginalExtension();;
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyAuthApp')->plainTextToken;
        $success['name'] =  $user->name;
        $success['avatar']=url($user->avatar);
 
   
        return $this->successResponse($success, 'User created successfully.');
    }

    static $registrationMethods = [
        'facebook' => "FACEBOOK",
        'email' => "EMAIL",
        'google'=>"GOOGLE"
    ];

public function facebook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'res' => false,
                'msg' => 'missing user token'
            ], 400);
        }

        $facebookUser = Socialite::driver('facebook')->userFromToken($request['token']);

        if (!$facebookUser) {
            return response()->json([
                'res' => false,
                'msg' => 'Invalid login details'
            ], 401);
        }
        $user = User::firstOrCreate([
            'method' => self::$registrationMethods['facebook'],
            'social_id' => $facebookUser->id,
            'email' => isset($facebookUser->email) ? $facebookUser->email : '',
        ], [
            'name' => $facebookUser->name,
        ]);

        $token = $user->createToken('auth_token');
        return response()->json([
            'access_token' => $token->plainTextToken,
            'token_type' => 'Bearer',
        ]);
    }
    public function google(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'res' => false,
                'msg' => 'missing user token'
            ], 400);
        }

        $googleUser = Socialite::driver('google')->userFromToken($request['token']);

        if (!$googleUser) {
            return response()->json([
                'res' => false,
                'msg' => 'Invalid login details'
            ], 401);
        }
        $user = User::firstOrCreate([
            'method' => self::$registrationMethods['google'],
            'social_id' => $googleUser->id,
            'email' => isset($googleUser->email) ? $googleUser->email : '',
        ], [
            'name' => $googleUser->name,
        ]);

        $token = $user->createToken('auth_token');
        return response()->json([
            'access_token' => $token->plainTextToken,
            'token_type' => 'Bearer',
        ]);
    }
}
