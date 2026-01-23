<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $request->session()->forget('is_admin');

        $products = Product::query()
            ->where('is_active', true)
            ->orderBy('category')
            ->orderBy('id')
            ->get();

        return view('products.index', [
            'products' => $products,
            'whatsappNumber' => config('goldenperfume.whatsapp_number'),
            'currency' => config('goldenperfume.currency'),
            'shopName' => config('goldenperfume.shop_name'),
        ]);
    }
}
