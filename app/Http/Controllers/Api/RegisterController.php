<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class RegisterController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255|unique:users',
            'password'  => 'required|min:4',
            'confirm_password'  => 'required|same:password',

        ]);
        if($validator->fails()){
            return $this->sendError('validator Error',$validator->errors());
        }
        $password = bcrypt($request->password);
        $users = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => $password

        ]);
        $succuss['token']   = $users->createToken('RestApi')->plainTextToken;
        $succuss['name']    = $users->name;

        return $this->sendResponse($succuss,'User registered Successfully');
    }

    public function login(Request $request){

        $validator = Validator::make($request->all(),[
            'email'  => 'required|max:255',
            'password'  => 'required|min:4'
        ]);
        if($validator->fails()){
            return $this->sendError('validation Error',$validator->errors());
        }
        if(Auth::attempt([
            'email'=> $request->email,'password' => $request->password]))
        {
            $user = Auth::user();
            $success['token']   = $user->createToken('RestApi')->plainTextToken;
            $success['name']    = $user->name;

            return $this->sendResponse($success,'login successfully');
        }else{
            return $this->sendError('unauthorized',['error'=>'unauthorized']);
        }
    }
}
