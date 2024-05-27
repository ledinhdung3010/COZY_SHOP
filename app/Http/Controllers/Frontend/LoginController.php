<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPostRequest;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Role;

class LoginController extends Controller
{
    public function index(){
        return view ('frontend.login.index');
    }
    public function handle(LoginPostRequest $request){
        $credentials = request(['username', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Tai khoan hoac mat khau sai'], 401);
        }else{
            $user=auth()->user()->role_id;
            $role=Role::find($user);
            if($role->name=="admin"){
                return response()->json([
                    'code'=>200,
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => auth()->factory()->getTTL() * 60,
                    'user'=>auth()->user(),
                    'role'=>'admin'
                ]);
            }else{
                return response()->json([
                    'code'=>200,
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => auth()->factory()->getTTL() * 60,
                    'user'=>auth()->user(),
                    'role'=>'user'
                ]);
            }
        }

        
       
    }
}
