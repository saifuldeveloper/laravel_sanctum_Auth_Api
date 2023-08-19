<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseController
{
    //

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'

        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error',$validator->errors());
        }

        if(Auth::attempt(['email' => $request->email,'password' => $request->password])){
            $user = Auth::user();
            $success['token'] = $user->createToken('RestApi')->plainTextToken;
            $success['name'] = $user->name;
            return $this->sendResponse($success,'User login successfully');
        }else{
            return $this->sendError('Unauthorised',['error' => 'Unauthorised']);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->sendResponse('','User logout successfully');
    }
}
