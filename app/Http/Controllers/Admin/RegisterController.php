<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterPostRequest;
use App\Http\Requests\UserPostRequest;
use Illuminate\Http\Request;
use App\Models\Account;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Str;
class RegisterController extends Controller
{
    
    public function index(){
        return view('admin.register.index');
    }
    public function indexResend(){
        return view('admin.register.resend');
    }
    public function checkEmail(){
        return view('admin.register.abc');
    }
    public function create(RegisterPostRequest $request){
        $nameImg='';
        if($request->hasFile('avatar')){
        
            $validate=Validator::make(
                $request->all(),
                [
                    'avatar'=>['max:2048','mimes:png,jpg,svg'],
                ],
                [
                    'avatar.max'=>'kich thuoc size qua lon',
                    'avatar.mimes'=>'anh sai dinh dang'
                ]

                );
            $img=$request->file('avatar');
            $nameImg=time().$img->getClientOriginalName();
            $img->move(public_path('upload/images/user'),$nameImg);
        }
        $username=Account::where('username',$request->username)->first();
        if($username){
            return response()->json(
                [
                    'username'=>"username da ton tai"
                ],500
            );
        }
        $email=Account::where('email',$request->email)->first();
        if($email){
            return response()->json(
                [
                    'email'=>"email da ton tai"
                ],500
            );
           
        }
        $token=time().Str::random(20);
       $data=[
        'username'=>$request->username,
        'password'=>Hash::make($request->password),
        'email'=>$request->email,
        'phone'=>$request->phone,
        'gender'=>$request->gender,
        'address'=>$request->address,
        'role_id'=>1,
        'status'=>0,
        'birthday'=>$request->birthday,
        'first_name'=>$request->first_name,
        'last_name'=>$request->last_name,
        'avatar'=>$nameImg,
        'verify_token'=>$token
       ];
       $emailUser=$request->email;
       $fullName=$request->username;
       $user_id = Account::insertGetId($data);
       $request->session()->put('emailVerify',$emailUser);
       $request->session()->put('fullnameVerify',$fullName);
       $request->session()->put('user_idVerify',$user_id);
       Mail::send('admin.register.send', compact('user_id','token'), function ($email) use ($emailUser, $fullName) {
        $email->to($emailUser, $fullName);
        $email->subject("Xac thuc dang ky tai khoan");
    });
       if($user_id){
            return response()->json(
                [
                    'message'=>'Vui long kiem tra email de xac thuc dang ky'
                ],200
            );
       }else{
            return response()->json(
                [
                    'message'=>'Dang ky khong thanh cong'
                ],500
            );
       }
    }
    public function verify(Request $request){
        $id=$request->id;
        $token=$request->token;
        $user=Account::find($id);
        if($user && $user->status=='1'){
            return response()->json(
                [
                    'message'=>'tai khoan da duoc xac thuc vui long dang nhap'
                ],200
            );
        }else{
            if($user  && Hash::check($token,$user->verify_token)){
                $user->update(['status'=>1]);
                Account::where('id',$id)->update(['verify_token'=>null]);
                $request->session()->forget('emailVerify');
                $request->session()->forget('fullnameVerify');
                return response()->json(
                    [
                        'message'=>'Xac thuc thanh cong'
                    ],200
                );
            }else{
                return response()->json(
                    [
                        'error'=>'Link da het han'
                    ],422
                );
            }
        }
      
    }
    public function resendEmail(Request $request){
        $emailUser= $request->session()->get('emailVerify');
        $fullName= $request->session()->get('fullnameVerify');
        $user_id =  $request->session()->get('user_idVerify');
        $token=time().Str::random(20);
        $token_verify=Hash::make($token);
        $user=Account::where(['id'=>$user_id,'status'=>1])->first();
        if(!empty($user)){
            return response()->json(
                [
                    'message'=> 'Tai khoan da duoc xac thuc vui long dang nhap'
                ],422
            );
        }
        Account::where('id',$user_id)->update(['verify_token'=>$token_verify]);
        Mail::send('admin.register.send', compact('user_id','token'), function ($email) use ($emailUser, $fullName) {
            $email->to($emailUser, $fullName);
            $email->subject("Xac thuc dang ky tai khoan");
        });
        return response()->json(
            [
                'message'=>'Vui long kiem tra email'

            ],200
        );
    }
    
}
