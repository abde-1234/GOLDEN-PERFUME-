<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Comment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->get('is_admin')) {
            return redirect()->route('admin.login');
        }

        $ordersTotal = Order::query()->count();
        $ordersNew = Order::query()->where('status', 'new')->count();
        $ordersProcessing = Order::query()->where('status', 'processing')->count();
        $ordersDone = Order::query()->where('status', 'done')->count();
        $ordersCancelled = Order::query()->where('status', 'cancelled')->count();

        $productsTotal = Product::query()->count();
        $productsActive = Product::query()->where('is_active', true)->count();

        $commentsTotal = Comment::query()->count();
        $commentsVisible = Comment::query()->where('is_visible', true)->count();

        return view('admin.dashboard', [
            'stats' => [
                'orders' => compact('ordersTotal', 'ordersNew', 'ordersProcessing', 'ordersDone', 'ordersCancelled'),
                'products' => compact('productsTotal', 'productsActive'),
                'comments' => compact('commentsTotal', 'commentsVisible'),
            ],
        ]);
    }
}
