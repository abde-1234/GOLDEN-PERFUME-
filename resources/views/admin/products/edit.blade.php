@extends('layouts.app')

@section('content')
<div class="admin-layout">
    @include('admin.partials.sidebar')

    <section>
        <div class="admin-hero p-4 mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 fw-bold mb-1">تعديل المنتج</h1>
                <p class="text-white text-opacity-75 mb-0">تحديث بيانات: {{ $product->name }}</p>
            </div>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-light rounded-pill px-4">
                &larr; رجوع
            </a>
        </div>

        <div class="card border-0 shadow-sm p-4 rounded-4">
            <form method="post" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                @csrf
                @method('put')
                
                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold">اسم المنتج</label>
                            <input name="name" class="form-control form-control-lg" value="{{ old('name', $product->name) }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">الوصف المختصر</label>
                            <textarea name="short_description" class="form-control" rows="4">{{ old('short_description', $product->short_description) }}</textarea>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">السعر ({{ $currency }})</label>
                                <div class="input-group">
                                    <input name="price" type="number" step="0.01" min="0" class="form-control form-control-lg" value="{{ old('price', $product->price) }}" required>
                                    <span class="input-group-text bg-light">{{ $currency }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">النوع</label>
                                <select name="category" class="form-select form-select-lg" required>
                                    <option value="perfume" @selected(old('category', $product->category) === 'perfume')>عطر</option>
                                    <option value="pack" @selected(old('category', $product->category) === 'pack')>Le Pack</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light border-0 p-3 mb-3">
                            <label class="form-label fw-bold mb-2">صورة المنتج</label>
                            @if($product->image_path)
                                <div class="mb-3">
                                    <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" class="img-fluid rounded border bg-white" style="max-height: 200px; width: 100%; object-fit: contain;">
                                </div>
                            @endif
                            <input name="image" type="file" class="form-control mb-2">
                            <div class="small text-muted">
                                <i class="bi bi-info-circle"></i> ارفع صورة جديدة لتغيير الحالية.
                            </div>
                        </div>

                        <div class="card bg-light border-0 p-3">
                            <label class="form-label fw-bold mb-2">حالة النشر</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" value="1" id="is_active" name="is_active" @checked(old('is_active', $product->is_active))>
                                <label class="form-check-label" for="is_active">
                                    تفعيل المنتج في المتجر
                                </label>
                            </div>
                            <div class="small text-muted mt-2">
                                عند التعطيل، لن يظهر المنتج للزبائن.
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-light rounded-pill px-4">إلغاء</a>
                    <button class="btn btn-primary rounded-pill px-5 fw-bold" type="submit" style="background-color: var(--gp-primary); border: none;">تحديث المنتج</button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
