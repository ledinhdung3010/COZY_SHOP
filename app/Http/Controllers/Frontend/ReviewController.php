<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Comment;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function createReview(Request $request){
        $name=$request->name;
        $email=$request->email;
        $start=$request->rating;
        $content=$request->review;
        $idPd=$request->idPd;
        $username=$request->username;
        $userId=Account::where('username',$username)->first();
        $data=[
            'email'=>$email,
            'start'=>$start,
            'content'=>$content,
            'productId'=>$idPd,
            'userId'=>$userId->id,
            'status'=>1,
            'created_at'=>date('Y-m-d H:i:s')
        ];
        $create=Comment::insertGetId($data);
        if($create){
            $comment=Comment::find($create);
            return response()->json(
                [
                    'message'=>'Them commnet thanh cong',
                    'comment'=>$comment

                ],200
            );
        }else{
            return response()->json(
                [
                    'error'=>'Them comment khong thanh cong'
                ],500
            );
        }
    }
}
