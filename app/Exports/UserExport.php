<?php

namespace App\Exports;

use App\Models\Account;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;


class UserExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    public function collection()
    {
        $products= Product::whereIn('id', $this->data)->select('id', 'name','image','list_image','price','is_sale','sale_price','quantity')->get();
        $products->prepend([
            'ID',
            'Name',
            'Image',
            'List_image',
            'Price',
            'Is_sale',
            'Sale_Price',
            'Quantity'
        ]);
    
        return $products;
    }
   
}
