<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Gloudemans\Shoppingcart\Facades\Cart;


class FrontendController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $carts = Cart::content();
            $cartTotal=0;
            foreach ($carts as $cartItem) {
                $priceSell = $cartItem->options->price_sell ?? $cartItem->price; // Fallback to the original price if price_sell is not set
                $cartTotal += $priceSell * $cartItem->qty;
            }
            $itemCarts = $carts->count();
            View::share('data', [
                'cart' => $carts,
                'total' => $cartTotal,
                'count' => $itemCarts,
            ]);
            return $next($request);
        });
       
    }
}
