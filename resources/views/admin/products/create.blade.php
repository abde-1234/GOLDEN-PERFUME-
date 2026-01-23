@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 section-title mb-0">إضافة منتج جديد</h1>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-dark btn-sm">رجوع لقائمة المنتجات</a>
    </div>

    <div class="card p-3">
        <form method="post" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">اسم المنتج</label>
                <input name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">النوع</label>
                <select name="category" class="form-select" required>
                    <option value="perfume" @selected(old('category') === 'perfume')>عطر</option>
                    <option value="pack" @selected(old('category') === 'pack')>Le Pack</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">الوصف المختصر</label>
                <textarea name="short_description" class="form-control" rows="3">{{ old('short_description') }}</textarea>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label">السعر ({{ $currency }})</label>
                    <input name="price" type="number" step="0.01" min="0" class="form-control" value="{{ old('price') }}" required>
                </div>
                <div class="col-md-8">
                    <label class="form-label">صورة المنتج</label>
                    <input name="image" type="file" class="form-control">
                    <div class="small-muted mt-1">يُفضّل صورة مربعة 1:1، حجم أقل من 2MB.</div>
                </div>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" @checked(old('is_active', true))>
                <label class="form-check-label" for="is_active">
                    منتج مفعل يظهر في المتجر
                </label>
            </div>
            <button class="btn btn-dark" type="submit">حفظ المنتج</button>
        </form>
    </div>
@endsection
