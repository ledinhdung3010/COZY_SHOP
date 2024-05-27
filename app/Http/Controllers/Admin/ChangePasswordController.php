<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function index(){
        return view('admin.changepassword.index');
    }
    public function change(Request $request){
        $user=Auth::user();
        $validate=Validator::make($request->all(),
        [
            'oldpassword'=>['required', function($attr,$value,$fail) use ($user){
                if(!Hash::check($value,$user->password)){
                    $fail('Mat khau sai');
                }
            }],

            'yourpassword'=>'required',
            'confirmpassword'=>'required|same:yourpassword'
        ],
        [
            'oldpassword.required'=>'Vui long nhap mat khau cu',
            'yourpassword.required'=>'Vui long nhap mat khau moi',
            'confirmpassword.required'=>'Vui long nhap lai mat khau moi',
            'confirmpassword.same'=>'Mat khau nhap lai khong trung nhau'
        ]
        );
        if($validate->fails()){
            return response()->json(
                [
                    'errors'=>$validate->errors()
                ],422
            );
        }else{
            $user->update(['password'=>Hash::make($request->yourpassword)]);
            return response()->json(
                [
                    'message'=>'Doi mat khau thanh cong'
                ],200
            );
        }
    }
}
