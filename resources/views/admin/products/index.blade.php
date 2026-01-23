@extends('layouts.app')

@section('content')
    <div class="admin-hero p-4 rounded-4 text-white d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h5 fw-bold mb-1">إدارة المنتجات</h1>
            <div class="d-flex flex-wrap gap-2">
                <span class="badge bg-white/10 text-white border border-white/20">📦 إجمالي: {{ $products->count() }}</span>
                <span class="badge bg-white/10 text-white border border-white/20">✅ مفعل: {{ $products->where('is_active', true)->count() }}</span>
                <span class="badge bg-white/10 text-white border border-white/20">🚫 مخفي: {{ $products->where('is_active', false)->count() }}</span>
            </div>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary rounded-pill" style="background-color: var(--gp-primary); border: none; color: #0b1120;">إضافة منتج جديد</a>
    </div>

    <div class="card p-3">
        @if($products->isEmpty())
            <div class="text-muted">لا توجد منتجات بعد.</div>
        @else
            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>النوع</th>
                        <th>السعر</th>
                        <th>الحالة</th>
                        <th style="width:150px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $p)
                        <tr>
                            <td>{{ $p->id }}</td>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->category === 'pack' ? 'Le Pack' : 'عطر' }}</td>
                            <td>{{ number_format($p->price, 2) }} {{ $currency }}</td>
                            <td>
                                @if($p->is_active)
                                    <span class="badge text-bg-success">مفعل</span>
                                @else
                                    <span class="badge text-bg-secondary">مخفي</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.products.edit', $p) }}" class="btn btn-sm btn-outline-dark rounded-pill px-3">تعديل</a>
                                <form method="post" action="{{ route('admin.products.destroy', $p) }}" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm btn-outline-danger" type="submit"
                                            onclick="return confirm('هل أنت متأكد من حذف هذا المنتج؟');">
                                        حذف
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
