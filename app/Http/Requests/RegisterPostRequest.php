<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterPostRequest extends FormRequest
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
            'username'=>'required',
            'password'=>'required|min:8',
            'email'=>'required|email',
            'phone'=>'required|numeric',
            'gender'=>'required',
            'first_name'=>'required',
            'last_name'=>'required'
        ];
    }
    public function messages(){
        return [
            'username.required'=>'UserName khong duoc de trong',
            'password.required'=>'Password khong duoc de trong',
            'password.min'=>'Password khong dung dinh dang',
            'email.required'=>'Email khong duoc de trong',
            'email.email'=>'Email sai dinh dang',
            'phone.required'=>'Phone khong duoc de trong',
            'phone.numeric'=>'Phone sai dinh dang',
            'gender.required'=>'Vui long chon gioi tinh',
            'first_name.required'=>"FirstName khong duoc de trong",
            'last_name.required'=>'LastName khong duoc de trong'
        ];
    }
}
