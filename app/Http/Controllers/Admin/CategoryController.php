<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryPostRequest;
use App\Models\Category;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends Controller
{
    public function index(Request $request){
        $keyword=$request->s;
        $category=Category::where('name','like',"%{$keyword}%")->get();
        return view('admin.category.index',['category'=>$category,'keyword'=>$keyword]);
    }
    public function delete(Request $request){
        $id=$request->id;
        $category=Category::find($id);
        if($category){
            $category->delete();
            return redirect()->route('admin.category')->with('delete_success', 'delete success');
        }
    }
    public function add(){
        return view('admin.category.add');
    }
    public function create(CategoryPostRequest $request){
        $nameImg='';
        if($request->hasFile('icon')){
            $validate=Validator::make(
                $request->all(),
                [
                    'icon'=>['max:2048','mimes:jpg,svg,png']
                ],
                [
                    'icon.max'=>'Kich thuoc cua anh vuot qua gioi han',
                    'icon.mimes'=>'Anh sai dinh dang'
                ]
                );
                if($validate->fails()){
                    return redirect()->route('admin.category.add')->withErrors($validate)->withInput();
                }
                $img=$request->icon;
                $nameImg=time().$img->getClientOriginalName();
                $img->move(public_path('upload/images/category'),$nameImg);

        }
        $data=[
            'name'=>$request->name,
            'slug'=>strtolower($request->name),
            'description'=>$request->description,
            'parent_id'=>'0',
            'type'=>1,
            'status'=>$request->status,
            'icon'=>$nameImg
        ];
        $category=Category::insert($data);
        if($category){
            return redirect()->route('admin.category')->with('insert_success', 'insert success');
        }
    }
    public function edit(Request $request){
        $id=$request->id;
        $category=Category::find($id);
        return view('admin.category.edit',['category'=>$category]);
    }
    public function update(CategoryPostRequest $request){
        $id=$request->id;
        $nameImg='';
        if($request->hasFile('icon')){
            $validate=Validator::make(
                $request->all(),
                [
                    'icon'=>['max:2048','mimes:jpg,svg,png']
                ],
                [
                    'icon.max'=>'Kich thuoc cua anh vuot qua gioi han',
                    'icon.mimes'=>'Anh sai dinh dang'
                ]
                );
                if($validate->fails()){
                    return redirect()->route('admin.category.edit',['id'=>$id])->withErrors($validate)->withInput();
                }
                $img=$request->icon;
                $nameImg=time().$img->getClientOriginalName();
                $img->move(public_path('upload/images/category'),$nameImg);

        }
        if(!empty($nameImg)){
            $data=[
                'name'=>$request->name,
                'slug'=>strtolower($request->name),
                'description'=>$request->description,
                'parent_id'=>'0',
                'type'=>1,
                'status'=>$request->status,
                'icon'=>$nameImg
            ];
        }else{
            $data=[
                'name'=>$request->name,
                'slug'=>strtolower($request->name),
                'description'=>$request->description,
                'parent_id'=>'0',
                'type'=>1,
                'status'=>$request->status
            ];
        }
       
        $category=Category::where('id',$id)->update($data);
        if($category){
            return redirect()->route('admin.category')->with('update_success', 'update thanh cong');
        }
    }
}
