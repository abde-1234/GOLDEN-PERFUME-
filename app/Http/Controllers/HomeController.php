<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $request->session()->forget('is_admin');

        $featuredProducts = Product::query()
            ->where('is_active', true)
            ->orderBy('id')
            ->take(3)
            ->get();

        $comments = Comment::query()
            ->where('is_visible', true)
            ->latest()
            ->get();

        return view('home', [
            'featuredProducts' => $featuredProducts,
            'comments' => $comments,
            'currency' => config('goldenperfume.currency'),
            'shopName' => config('goldenperfume.shop_name'),
        ]);
    }
}
