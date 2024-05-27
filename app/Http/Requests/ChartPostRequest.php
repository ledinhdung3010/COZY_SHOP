<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChartPostRequest extends FormRequest
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
            'date1'=>'required',
            'date2'=>'required'
        ];
    }
    public function messages(){
        return [
            'date1.required'=>'Vui long nhap ngay bat dau',
            'date2.required'=>'Vui long nhap ngay ket thuc'
        ];
    }
}
