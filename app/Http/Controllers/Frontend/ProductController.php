<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use Gloudemans\Shoppingcart\Facades\Cart;

// use Illuminate\Support\Facades\Response;

use App\Http\Controllers\Frontend\FrontendController;
class ProductController extends FrontendController
{
    public function detail(Request $request){
        $id=$request->id;
        $slug=$request->slug;
        $comment=Comment::where('productId',$id)->get();
        $infProduct=Product::select('products.*','categories.name as categories_name','categories.slug as category_slug')
        ->join('categories','products.categories_id','=','categories.id')
        ->where('products.id',$id)->first();
        if(!empty($infProduct)){
            $colorProduct=Color::select('colors.*')
                            ->join('product_color','colors.id','=','product_color.color_id')
                            ->where('product_id',$id)
                            ->get();
            $sizeProduct=Size::select('sizes.*')
            ->join('product_size','sizes.id','=','product_size.size_id')
            ->where('product_id',$id)
            ->get();
            $reletedProduct=Product::select('products.*','categories.id as categories_id','categories.slug as category_slug')
            ->join('categories','products.categories_id','=','categories.id')
            ->where('categories_id',$infProduct->categories_id)
                                        ->where('products.id','!=',$id)
                                        ->skip(config('common.panigator.releted_product.skip'))
                                        ->take(config('common.panigator.releted_product.take'))
                                        ->get();
          
            if(!empty($infProduct->list_image)){
                if (count(json_decode($infProduct->list_image)) != 0) {
                    $list_img=json_decode($infProduct->list_image);
                } else {
                    $list_img = [$infProduct->image];
                }
            }
            
            return response()->json(
                [
                    'data'=>[
                        'infoProduct'=>$infProduct,
                        'list_images'=>$list_img,
                        'colorProduct'=>$colorProduct,
                        'sizeProduct'=>$sizeProduct,
                        'relatedProduct'=>$reletedProduct,
                        'comment'=>$comment
                       
                    ],
                    'message'=>'thanh cong',
                    'status'=>200
                ]
                
            );
            
        }else{
            return response()->json(
                [
                    'data'=>[                       
                    ],
                    'message'=>'Not found product',
                    'status'=>400
                ]
                
            );
        }
    }
    public function view(){
        return view('frontend.product.detail');
    }
}
