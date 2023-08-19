<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use  Illuminate\Support\Facades\Validator;
use App\Models\User;

class RegisterController extends BaseController
{

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required |string |max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'c_password' => 'required|same:password'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error',$validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email, 
            'password' => bcrypt($request->password)
        ]);
        $success['token'] = $user->createToken('RestApi')->plainTextToken;
        $success['name'] = $user->name;
        
        return $this->sendResponse($success, 'User registered successfully');
    }

    
}
