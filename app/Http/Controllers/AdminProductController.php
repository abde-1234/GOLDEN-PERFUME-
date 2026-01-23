<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    private function ensureAdmin(Request $request)
    {
        if (!$request->session()->get('is_admin')) {
            return redirect()->route('admin.login');
        }

        return null;
    }

    public function index(Request $request)
    {
        if ($redirect = $this->ensureAdmin($request)) {
            return $redirect;
        }

        $products = Product::query()
            ->orderBy('category')
            ->orderBy('id')
            ->get();

        return view('admin.products.index', [
            'products' => $products,
            'currency' => config('goldenperfume.currency'),
        ]);
    }

    public function create(Request $request)
    {
        if ($redirect = $this->ensureAdmin($request)) {
            return $redirect;
        }

        return view('admin.products.create', [
            'currency' => config('goldenperfume.currency'),
        ]);
    }

    public function store(Request $request)
    {
        if ($redirect = $this->ensureAdmin($request)) {
            return $redirect;
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:perfume,pack'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
        ], [], [
            'name' => 'اسم المنتج',
            'category' => 'النوع',
            'short_description' => 'الوصف المختصر',
            'price' => 'السعر',
            'image' => 'صورة المنتج',
            'is_active' => 'حالة التفعيل',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $validated['name'],
            'category' => $validated['category'],
            'short_description' => $validated['short_description'] ?? null,
            'price' => $validated['price'],
            'image_path' => $path ? ('storage/'.$path) : null,
            'is_active' => $validated['is_active'],
        ]);

        return redirect()->route('admin.products.index')->with('success', 'تم إضافة المنتج بنجاح.');
    }

    public function edit(Request $request, Product $product)
    {
        if ($redirect = $this->ensureAdmin($request)) {
            return $redirect;
        }

        return view('admin.products.edit', [
            'product' => $product,
            'currency' => config('goldenperfume.currency'),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        if ($redirect = $this->ensureAdmin($request)) {
            return $redirect;
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:perfume,pack'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
        ], [], [
            'name' => 'اسم المنتج',
            'category' => 'النوع',
            'short_description' => 'الوصف المختصر',
            'price' => 'السعر',
            'image' => 'صورة المنتج',
            'is_active' => 'حالة التفعيل',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $data = [
            'name' => $validated['name'],
            'category' => $validated['category'],
            'short_description' => $validated['short_description'] ?? null,
            'price' => $validated['price'],
            'is_active' => $validated['is_active'],
        ];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image_path'] = 'storage/'.$path;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'تم تعديل المنتج بنجاح.');
    }

    public function destroy(Request $request, Product $product)
    {
        if ($redirect = $this->ensureAdmin($request)) {
            return $redirect;
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'تم حذف المنتج.');
    }
}
