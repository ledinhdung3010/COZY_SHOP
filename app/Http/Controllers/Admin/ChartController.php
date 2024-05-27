<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChartPostRequest;
use App\Models\Account;
use App\Models\Order_detail;
use App\Models\Product;
use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChartController extends Controller
{
    public function index()
    {   $product=Product::withTrashed()->get();
        return view('admin.charts.index',['products'=>$product]);
    }
    public function amount(){
        $product=Product::withTrashed()->get();
        return view('admin.charts.amount',['products'=>$product]);
    }
    public function byAmount(Request $request){
        $date1=$request->date1;
        $date2=$request->date2;
        $productName=$request->product;
        if($date1==''){
            return response()->json([
                'cod'=>401,
                'error'=>'Vui long chon thoi gian '
            ]);
        }if($date2==''){
            return response()->json([
                'cod'=>401,
                'error'=>'Vui long chon thoi gian'
            ]);
        }
        if($date1!=''&& $date2!=''){
            $time1 = Carbon::parse($date1);
            $time2 = Carbon::parse($date2);
            if($productName){
                if($time1==$time2){
                    $product=Order_detail::select("products.name",DB::raw('SUM(order_details.quantity*order_details.unitprice) as total_quantity'))
                        ->join('products','order_details.product_id','=','products.id')
                        ->groupBy('products.id', 'products.name')
                        ->where('order_details.created_at',$date1)
                        ->where('products.name',$productName)
                        ->get();
                }else{
                    $product=Order_detail::select("products.name",DB::raw('SUM(order_details.quantity*order_details.unitprice) as total_quantity'))
                    ->join('products','order_details.product_id','=','products.id')
                    ->groupBy('products.id', 'products.name')
                    ->whereBetween('order_details.created_at', ["$request->date1","$request->date2"])
                    ->where('products.name',$productName)
                    ->get();
                }
            }else{
                if($time1==$time2){
                    $product=Order_detail::select("products.name",DB::raw('SUM(order_details.quantity*order_details.unitprice) as total_quantity'))
                        ->join('products','order_details.product_id','=','products.id')
                        ->groupBy('products.id', 'products.name')
                        ->where('order_details.created_at',$date1)
                        ->get();
                }else{
                    $product=Order_detail::select("products.name",DB::raw('SUM(order_details.quantity*order_details.unitprice) as total_quantity'))
                    ->join('products','order_details.product_id','=','products.id')
                    ->groupBy('products.id', 'products.name')
                    ->whereBetween('order_details.created_at', ["$request->date1","$request->date2"])
                    ->get();
                }
            }
            return response()->json([
                'cod'=>200,
                'products'=>$product
            ]);
        }
        
    }
    public function statistical(Request $request){
        $date1=$request->date1;
        $date2=$request->date2;
        $productName=$request->product;
        if($date1==''){
            return response()->json([
                'cod'=>401,
                'error'=>'Vui long chon thoi gian '
            ]);
        }if($date2==''){
            return response()->json([
                'cod'=>401,
                'error'=>'Vui long chon thoi gian'
            ]);
        }
        if($date1!=''&& $date2!=''){
            $time1 = Carbon::parse($date1);
            $time2 = Carbon::parse($date2);
            if($productName){
                if($time1==$time2){
                    $product=Order_detail::select("products.name",DB::raw('SUM(order_details.quantity) as total_quantity'))
                        ->join('products','order_details.product_id','=','products.id')
                        ->groupBy('products.id', 'products.name')
                        ->where('order_details.created_at',$date1)
                        ->where('products.name',$productName)
                        ->get();
                }else{
                    $product=Order_detail::select("products.name",DB::raw('SUM(order_details.quantity) as total_quantity'))
                    ->join('products','order_details.product_id','=','products.id')
                    ->groupBy('products.id', 'products.name')
                    ->whereBetween('order_details.created_at', ["$request->date1","$request->date2"])
                    ->where('products.name',$productName)
                    ->get();
                }
            }else{
                if($time1==$time2){
                    $product=Order_detail::select("products.name",DB::raw('SUM(order_details.quantity) as total_quantity'))
                        ->join('products','order_details.product_id','=','products.id')
                        ->groupBy('products.id', 'products.name')
                        ->where('order_details.created_at',$date1)
                        ->get();
                }else{
                    $product=Order_detail::select("products.name",DB::raw('SUM(order_details.quantity) as total_quantity'))
                    ->join('products','order_details.product_id','=','products.id')
                    ->groupBy('products.id', 'products.name')
                    ->whereBetween('order_details.created_at', ["$request->date1","$request->date2"])
                    ->get();
                }
            }
            return response()->json([
                'cod'=>200,
                'products'=>$product
            ]);
        }
        
    }
    
    
}
