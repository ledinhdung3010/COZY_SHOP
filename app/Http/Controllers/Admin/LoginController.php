<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\ColorPostRequest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginPostRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Str;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Helper\CommonHelper;
use App\Models\Role;
class LoginController extends Controller
{
    // public function __construct(){
    //     $this->middleware('is.login.admin')->except(['logout']);
    // }
    public function index(){
        // tra ve 1 giao dien 
        return view('admin.login.index');
    }
    public function handleLogin(LoginPostRequest $request){
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
 
    public function logout(Request $request){
        JWTAuth::invalidate(JWTAuth::getToken());
    }
    public function resetPassword(){
        return view('admin.login.resetpassword');
    }
    public function checkEmail(Request $request){
        $emailUser=$request->email;
        $key='dung30102003';
        $user=Account::where(['email'=>$emailUser])->first();
        $validator=Validator::make($request->all(),
            [
                'email'=>'required|email'
            ],
            [
                'email.required'=>"Vui long nhap email",
                'email.email'=>"email sai dinh dang"
            ]
            );
            if ($validator->fails()) {
                return response()->json(
                  [
                    'errors'=>$validator->errors()
                  ],422
                );
            }else{
                if(!empty($user)){
                    $fullName=$user->username;
                    $id=$user->id;
                    $request->session()->put('emailVerify',$emailUser);
                    $request->session()->put('fullnameVerify',$fullName);
                    $request->session()->put('user_idVerify',$id);
                    $token_resetpassword=time().Str::random(20);
                    $token=Crypt::encryptString($token_resetpassword);
                    Account::where(['email'=>$emailUser])->update(['token_resetpassword'=>$token_resetpassword]);
                    Mail::send('admin.login.emailreset', compact('id','token_resetpassword'), function ($email) use ($emailUser, $fullName) {
                        $email->to($emailUser, $fullName);
                        $email->subject("Reset Password");
                    });
                    return response()->json(
                        [
                            'message'=>'vui long kiem tra email'
                        ],200
                    );
                }else{
                    return response()->json(
                        [
                            'message','Email chua duoc dang ki'
                        ],422
                    );
                }
            }
    }
    public function viewResend(){
        return view('admin.login.resend_resetpassword');
    }
    
    public function resend_ResetPassword(Request $request){
        $emailUser= $request->session()->get('emailVerify');
        $fullName= $request->session()->get('fullnameVerify');
        $id =  $request->session()->get('user_idVerify');
        $user=Account::find($id);
        $token_resetpassword=time().Str::random(20);
        $token=Crypt::encryptString($token_resetpassword);
        Account::where(['email'=>$emailUser])->update(['token_resetpassword'=>$token_resetpassword]);
        Mail::send('admin.login.emailreset', compact('id','token_resetpassword'), function ($email) use ($emailUser, $fullName) {
            $email->to($emailUser, $fullName);
            $email->subject("Reset Password");
        });
        return view('admin.login.resend_resetpassword');
    }
    public function handleResetPassword(Request $request){
        $id=$request->id;
        $code=$request->code;
        $user=Account::find($id);
        if($user->token_resetpassword!=$code){
            return view('admin.login.resetpassword')->with('error_resetpassword','Đường link đã hết hạn');
        }else{
            return view('admin.login.resetpass',['id'=>$id,'code'=>$code]);
        }

    }
    public function updatePassword(Request $request){
        $validate=Validator::make($request->all(),
        [
            'password'=>'required'
        ],
        [
            'password.required'=>"Vui long nhap password"
        ]);
        if($validate->fails()){
            return redirect()->back()->withErrors($validate);
        }else{
            $id=$request->id;
            $code=$request->code;
            $user=Account::find($id);
            if($user->token_resetpassword!=$code){
                return view('admin.login.resetpassword')->with('error_resetpassword','Đường link đã hết hạn');
            }else{
                Account::where('id',$id)->update(['password'=>Hash::make($request->password),'token_resetpassword'=>null]);
                return redirect()->route('admin.login')->with('insert_success_resetpassword', 'Doi mat khau thanh cong');
            }
        }
    }
    public function checkToken(){
        return response()->json(
            [
                'message'=>'token con thoi han'
            ]
        );
    }
    public function registerExcel(Request $request){
        $file = $request->file('file_user');
        $list_img=$request->file('list_image');
    // Kiểm tra xem tệp đã được tải lên chưa
    if ($file&&$list_img) {
        $filePath = $file->getRealPath();

        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
     
        $data = [];
        foreach ($sheet->getRowIterator() as $row) {
            $rowData = [];
            foreach ($row->getCellIterator() as $cell) {
                $rowData[] = $cell->getValue();
            }
            $data[] = $rowData;
        }
        $data2=[];

        foreach ($data as $accountData) {
            foreach($list_img as $img){
                if($accountData[9]==$img->getClientOriginalName()){
                    $nameImg = time().$img->getClientOriginalName();
                    $img->move(public_path('upload/images/product'), $nameImg);
                    $data2[]=$nameImg;
                }
                if($accountData[10]==$img->getClientOriginalName()){
                    $nameImg = time().$img->getClientOriginalName();
                    $img->move(public_path('upload/images/product'), $nameImg);
                    $data2[]=$nameImg;
                }
            }
            $dataUser=[
                'name'=>$accountData[0],
                'categories_id'=>$accountData[1],
                'description'=>$accountData[3],
                'slug'=>CommonHelper::slugVietnamese($accountData[0]),
                'price'=>$accountData[5],
                'quantity'=>$accountData[8],
                'image'=>array_shift($data2),
                'list_image'=>json_encode($data2)
            ];
            Product::insert($dataUser);
        }
        return redirect()->route('admin.login');
    }
    }
}
