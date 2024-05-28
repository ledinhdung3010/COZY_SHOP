<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Frontend\FrontendController;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Requests\StorePostCustomerPayment;
use App\Models\Order;
use Illuminate\Support\Str;
use App\Models\Order_detail;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
class OderController extends FrontendController
{
    public function checkout(){
        if(Cart::count()==0){
            return response()->json(
                [
                    'message'=>'chuwa co san pham nao'
                ],401
            );
        }
        return response()->json(
            [
                'message'=>'thanh cong vui long chuyen huong den checkout'
            ],200
        );
    }
    public function viewCheckout(){
        return view('frontend.order.checkout');
    }
    public function Cart(){
        $carts = Cart::content();
        $cartTotal = 0;
        $itemCarts = $carts->count();
        foreach ($carts as $cartItem) {
            $priceSell = $cartItem->options->price_sell ?? $cartItem->price; // Fallback to the original price if price_sell is not set
            $cartTotal += $priceSell * $cartItem->qty;
        }
        return response()->json([
            'cart' => $carts,
            'total' => $cartTotal,
            'count' => $itemCarts,
        ]);
    }
    public function payment(StorePostCustomerPayment $request)
    {
        $carts = Cart::content();
        $cartTotal = 0;
        $itemCarts = $carts->count();
        foreach ($carts as $cartItem) {
            $priceSell = $cartItem->options->price_sell ?? $cartItem->price; // Fallback to the original price if price_sell is not set
            $cartTotal += $priceSell * $cartItem->qty;
        }
        $validatedData = $request->validated();
        session()->put('full_name', $request->full_name);
        session()->put('email', $request->email);
        session()->put('phone', $request->phone);
        session()->put('address', $request->address);
        $check=$request->checkpay;
        $pay=$request->payment;
        if($pay=='1'){
            $extrs_code="";
            if(Cart::count()!=0){
                $emailUser=$request->email;
                $fullName=$request->full_name;
                $extrs_code=time().Str::random(10);
                $dataInfo=[
                    'extrs_code'=>$extrs_code,
                    'full_name'=>$request->full_name,
                    'phone'=>$request->phone,
                    'status'=>'1',
                    'email'=>$request->email,
                    'nots'=>$request->nots ? $request->nots : null ,
                    'payment'=>1,
                    'order_date'=>date('Y-m-d H:i:s'),
                    'address'=>$request->address,
                    'created_at'=>date('Y-m-d H:i:s')
                ];
                $insertOrder=Order::insertGetId($dataInfo);
                $dataProduct=[];
                foreach(Cart::content() as $item ){
                    $dataProduct[]=[
                        'order_id'=>$insertOrder,
                        'product_id'=>$item->id,
                        'color_name'=>$item->options->color,
                        'size_name'=>$item->options->size,
                        'quantity'=>$item->qty,
                        'unitprice'=>$item->price,
                        'status'=>1,
                        'created_at'=>date('Y-m-d H:i:s')
                    ];
                }
                $insert=Order_detail::insert($dataProduct);
                if($insert){
                    Cart::destroy();
                    // sang trang xem lai don hang vua dat
                    $link = 'http://127.0.0.1:8000/order_detail?extrs_code='.$extrs_code.'&id='.$insertOrder;  // URL hoặc bất kỳ văn bản nào bạn muốn mã hóa
                    $qrCode = QrCode::size(200)->generate($link);
                    $temporaryFilePath = storage_path('app/public/qrcodes/qrcode.png');
                    Storage::disk('public')->put('qrcodes/qrcode.png', $qrCode);
                    Mail::send('frontend.order.send',['qrCodeFilePath' => $temporaryFilePath], function ($email) use ($emailUser, $fullName, $extrs_code,$temporaryFilePath) {
                        $email->to($emailUser, $fullName); 
                        $email->subject("Bạn đã đặt đơn hàng #$extrs_code");
                        $email->attach($temporaryFilePath, [
                            'as' => 'qrcode.png', // Tên file đính kèm
                            'mime' => 'image/png', // Loại MIME của file
                        ]);
                    });
                   
               
                    // Storage::disk('public')->delete('qrcodes/qrcode.png');
                    return response()->json([
                        'code'=>200,
                        'message'=>'Payment successful',
                        'data'=>[
                            'extrs_code'=>$extrs_code,
                            'id'=>$insertOrder,
                            'pay'=>'code'
                        ]
                    ]);
                   
                }
            }
            return redirect()->back()->with('error_payment','payment invalid');
        }else{
            if($pay=="2"){
                $extrs_code=time().Str::random(10);
                $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
                $vnp_Returnurl =route('frontend.view.vnpay');
                $vnp_TmnCode = "EEYAMMAB";//Mã website tại VNPAY 
                $vnp_HashSecret = "PTCRDMMVWAXBAUMLMQMMNJFAFMDPKDIV"; //Chuỗi bí mật
                
                $vnp_TxnRef = $extrs_code; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này 
                $vnp_OrderInfo ="Noi dung thanh toan";
                $vnp_OrderType = 'billpayment';
                $vnp_Amount = $cartTotal*100;
                $vnp_Locale = 'vn';
                $vnp_BankCode = 'NCB';
                $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
               
                
                $inputData = array(
                    "vnp_Version" => "2.1.0",
                    "vnp_TmnCode" => $vnp_TmnCode,
                    "vnp_Amount" => $vnp_Amount,
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_CurrCode" => "VND",
                    "vnp_IpAddr" => $vnp_IpAddr,
                    "vnp_Locale" => $vnp_Locale,
                    "vnp_OrderInfo" => $vnp_OrderInfo,
                    "vnp_OrderType" => $vnp_OrderType,
                    "vnp_ReturnUrl" => $vnp_Returnurl,
                    "vnp_TxnRef" => $vnp_TxnRef
                );
                
                if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                    $inputData['vnp_BankCode'] = $vnp_BankCode;
                }
                ksort($inputData);
                $query = "";
                $i = 0;
                $hashdata = "";
                foreach ($inputData as $key => $value) {
                    if ($i == 1) {
                        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                    } else {
                        $hashdata .= urlencode($key) . "=" . urlencode($value);
                        $i = 1;
                    }
                    $query .= urlencode($key) . "=" . urlencode($value) . '&';
                }
                
                $vnp_Url = $vnp_Url . "?" . $query;
                if (isset($vnp_HashSecret)) {
                    $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
                    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
                }
                $returnData = array('code' => '00'
                    , 'message' => 'success'
                    , 'data' => $vnp_Url);
                    if ($check) {
                        return response()->json(
                            [
                                'data'=>[
                                    'url'=>$vnp_Url,
                                    'pay'=>'vnpay'
                                ]
                               
                            ]
                        );
                       
                    } else {
                        echo json_encode($returnData);
                    }
                
            }
        }
        
    }

    public function handleVnPayCallback(Request $request){
        if ($request->filled('vnp_ResponseCode')) {
            // Lấy các thông tin từ VNPAY callback
            $responseCode = $request->input('vnp_ResponseCode');
            $extrs_code=time().Str::random(10);
            $emailUser=session()->get('email');
            $fullName=session()->get('full_name');
            // Kiểm tra trạng thái thanh toán từ VNPAY
            if ($responseCode === '00') {
                $dataInfo=[
                    'extrs_code'=>$extrs_code,
                    'full_name'=>session()->get('full_name'),
                    'phone'=>session()->get('phone'),
                    'status'=>'1',
                    'email'=>session()->get('email'),
                    'order_date'=>date('Y-m-d H:i:s'),
                    'address'=>session()->get('address'),
                    'payment'=>2,
                    'nots'=>$request->nots,
                    'created_at'=>date('Y-m-d H:i:s')
                ];
                $insertOrder=Order::insertGetId($dataInfo);
                $dataProduct=[];
                foreach(Cart::content() as $item ){
                    $dataProduct[]=[
                        'order_id'=>$insertOrder,
                        'product_id'=>$item->id,
                        'color_name'=>$item->options->color,
                        'size_name'=>$item->options->size,
                        'quantity'=>$item->qty,
                        'unitprice'=>$item->price,
                        'status'=>1,
                        'created_at'=>date('Y-m-d H:i:s')
                    ];
                }
                $insert=Order_detail::insert($dataProduct);
                if($insert){
                    Cart::destroy();
                    
                    $link = 'http://127.0.0.1:8000/order_detail/'.$extrs_code; // Địa chỉ email của người nhận
                    $qrCode = QrCode::size(200)->generate($link);
                    Mail::send('frontend.order.send', compact('link','qrCode'), function ($email) use ($emailUser, $fullName, $extrs_code) {
                        $email->to($emailUser, $fullName);
                        $email->subject("Bạn đã đặt đơn hàng #$extrs_code");
                    });
                
                    return response()->json([
                        'code'=>200,
                        'message'=>'Payment successful',
                        'data'=>[
                            'extrs_code'=>$extrs_code,
                            'id'=>$insertOrder,
                            'pay'=>'vnpay'
                        ]
                    ]);
                }
            } else {
                // Thanh toán không thành công, xử lý tùy thuộc vào trường hợp
                return response()->json([
                    'code'=>400,
                    'message'=>'Payment fail',
                    
                ]);
            }
        } else {
            return response()->json([
                'code'=>400,
                'message'=>'Payment fail',
                
            ]);
        }
    }
    public function showorder(Request $request){
        $extrs_code=$request->extrs_code;
        $id=$request->id;
        $product=Product::select('products.*','order_details.color_name as color_name','order_details.size_name as size_name','order_details.quantity as qtyprice')
        ->join('order_details','order_details.product_id','=','products.id')
        ->where('order_details.order_id',function ($query) use ($extrs_code) {
            $query->select('id')->from('orders')->where('extrs_code', $extrs_code);
        })
        ->where('order_details.order_id', $id)
        ->get();
        $orders=Order::where('extrs_code',$extrs_code)
                ->where('id', $id)
                ->first();
        return response()->json(
            [
                'data'=>[
                    'products'=>$product,
                    'orders'=>$orders
                ]
            ]
        );
      
    }
    
    public function callBackVnpay(){
        return view('frontend.order.vnpay');
    }
    public function viewBillDetail(){
        return view('frontend.order.order_detail');
    }
}
