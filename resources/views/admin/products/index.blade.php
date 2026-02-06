@extends('layouts.app')

@section('content')
<div class="admin-layout">
    @include('admin.partials.sidebar')

    <section>
        <div class="admin-hero p-4 mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 fw-bold mb-2">إدارة المنتجات</h1>
                 <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-white bg-opacity-25 text-white border border-white border-opacity-25">📦 إجمالي: {{ $products->count() }}</span>
                    <span class="badge bg-white bg-opacity-25 text-white border border-white border-opacity-25">✅ مفعل: {{ $products->where('is_active', true)->count() }}</span>
                    <span class="badge bg-white bg-opacity-25 text-white border border-white border-opacity-25">🚫 مخفي: {{ $products->where('is_active', false)->count() }}</span>
                </div>
            </div>
            <a href="{{ route('admin.products.create') }}" class="btn btn-light rounded-pill px-4 fw-bold text-dark">
               + إضافة منتج
            </a>
        </div>

        <div class="card border-0 shadow-sm p-3 rounded-4">
            @if($products->isEmpty())
                <div class="text-muted p-3 text-center">لا توجد منتجات بعد.</div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="bg-light">
                        <tr>
                            <th class="border-0 rounded-start">#</th>
                            <th class="border-0">الاسم</th>
                            <th class="border-0">النوع</th>
                            <th class="border-0">السعر</th>
                            <th class="border-0">الحالة</th>
                            <th class="border-0 rounded-end" style="width:150px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $p)
                            <tr>
                                <td class="fw-bold text-muted">{{ $p->id }}</td>
                                <td class="fw-bold">{{ $p->name }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $p->category === 'pack' ? 'Le Pack' : 'عطر' }}</span>
                                </td>
                                <td class="fw-bold text-primary">{{ number_format($p->price, 2) }} {{ $currency }}</td>
                                <td>
                                    @if($p->is_active)
                                        <span class="badge bg-success bg-opacity-10 text-success px-3">مفعل</span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary px-3">مخفي</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.products.edit', $p) }}" class="btn btn-sm btn-light border rounded-pill px-3">تعديل</a>
                                    <form method="post" action="{{ route('admin.products.destroy', $p) }}" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-sm btn-light border text-danger rounded-circle" type="submit"
                                                onclick="return confirm('هل أنت متأكد من حذف هذا المنتج؟');" title="حذف">
                                            &times;
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
    </section>
</div>
@endsection
