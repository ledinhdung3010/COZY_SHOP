<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(Request $request){
        $keyword=$request->s;
        $tag=Tag::where('name','like',"%{$keyword}%")->get();
        return view('admin.tag.index',['tag'=>$tag,'keyword'=>$keyword]);
    }
}
