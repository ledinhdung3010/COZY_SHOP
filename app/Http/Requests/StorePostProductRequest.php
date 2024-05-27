<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\SalePriceValidate;

class StorePostProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'required|min:2|max:150',
            'category'=>'required|numeric',
            'description'=>'required',
            'price'=>['required','numeric',new SalePriceValidate],
            'list_image'=>['required','max:2048'],
            'list_image.*'=>'mimes:jpg,png,svg',
            'quantity'=>'required|numeric',
            'status'=>'required',
            'color'=>'required',
            'size'=>'required',
            'tag'=>'required'
            

        ];
    }
    public function messages(){
        return [
            'name.required'=>'ten khong duoc de trong',
            'name.min'=>'ten khong duoc be hon 2 ky tu',
            'name.max'=>'ten khong duoc vuot qua 150 ky tu',
            'category.required'=>"vui long chon danh muc",
            'category.numeric'=>"Du lieu khong chinh xac",
            'description.required'=>'mo ta san pham khong duoc de trong',
            'price.required'=>'vui long nhap gia san pham',
            'price.numeric'=>'gia san pham phai la so',
            'list_image.required'=>'vui long chon anh san pham',
            'list_image.*.mimes'=>'dinh dang anh sai anh chap nhan jpg,svg,png',
            'list_image.max'=>'kich thuoc size qua lon',
            'quantity.required'=>'vui long so luong san pham',
            'quantity.numeric'=>'so luong san pham phai la so',
            'status.required'=>'vui long nhap trang thai',
            'color.required'=>'vui long chon color',
            'size.required'=>'vui long chon size',
            'tag.required'=>'vui long chon tag'

        ];
       

    }
}
