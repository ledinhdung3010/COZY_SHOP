<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;
class LoginGoogleController extends Controller
{
        public function redirectToGoogle()
        {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
        return view('admin.login.abc');
    }
    public function gg(Request $request){
        
        try {
            $code=$request->code;
            $tokenResponse = Socialite::driver('google')->getAccessTokenResponse($code);
            $accessToken = $tokenResponse['access_token'];
            $user = Socialite::driver('google')->userFromToken($accessToken);
            $account=Account::where('email',$user->email)->first();
            if($account){
                Account::where('email',$user->email)->update(
                    [
                        
                    'google_id'=>$user->id,
                    'avatar_google'=>$user->avatar,
                    'name_google'=>$user->name
                    ]
                    );
            }else{
                $data=[
                    'username'=>$user->name,
                        'password'=>Hash::make(Str::random(40)),
                        'email'=>$user->email,
                        'gender'=>'1',
                        'first_name'=>$user->user['given_name'],
                        'last_name'=>$user->user['family_name'],
                        'role_id'=>1,
                        'phone'=>123,
                        'google_id'=>$user->id,
                        'avatar_google'=>$user->avatar,
                        'name_google'=>$user->username,
                        'status'=>1
                ];
                Account::insert($data);
            }
            $account=Account::where('email',$user->email)->first();
            $expiresIn = $tokenResponse['expires_in'];
            $expiry = now()->addSeconds($expiresIn);
            $customClaims = ['exp' => $expiry->timestamp]; // UNIX timestamp của thời điểm hết hạn
            $accessToken = JWTAuth::claims($customClaims)->fromUser($account);
            return response()->json(
                [
                    'access_token'=>$accessToken,
                    'avatar_google'=>$user->avatar,
                    'username'=>$user->name,
                    'token_type' => 'bearer',
                    'expires_in' => JWTAuth::factory()->getTTL() * 60
                ],200
            );
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    
    }
}
