@extends('layouts.app')

@section('content')
<div class="admin-layout">
    @include('admin.partials.sidebar')

    <section>
        <div class="admin-hero p-4 mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 fw-bold mb-1">تفاصيل الطلب #{{ $order->id }}</h1>
                <p class="text-white text-opacity-75 mb-0">تم الإنشاء: {{ $order->created_at?->format('Y-m-d H:i') }}</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-light rounded-pill px-4">
                    &larr; رجوع
                </a>
                <form method="post" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطلب؟');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-light text-danger fw-bold rounded-pill px-4" type="submit">حذف الطلب</button>
                </form>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-4 rounded-4 mb-4 h-100">
                    <h5 class="fw-bold mb-3 border-bottom pb-2">معلومات الزبون</h5>
                    <div class="mb-2">
                        <small class="text-muted d-block">الاسم</small>
                        <div class="fw-bold">{{ $order->customer_name }}</div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted d-block">الهاتف</small>
                        <div class="fw-bold" dir="ltr">{{ $order->customer_phone }}</div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted d-block">العنوان</small>
                        <div>{{ $order->customer_address }}</div>
                    </div>
                    @if($order->customer_note)
                        <div class="mt-3 p-3 bg-light rounded-3 border border-light-subtle">
                            <small class="text-muted d-block fw-bold mb-1">ملاحظة الزبون:</small>
                            <div class="text-muted fst-italic">{{ $order->customer_note }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-8">
                <!-- Status Card -->
                <div class="card border-0 shadow-sm p-4 rounded-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">حالة الطلب</h5>
                        @switch($order->status)
                            @case('new') <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">جديد</span> @break
                            @case('processing') <span class="badge bg-info text-dark px-3 py-2 rounded-pill">قيد التجهيز</span> @break
                            @case('done') <span class="badge bg-success px-3 py-2 rounded-pill">مكتمل</span> @break
                            @case('cancelled') <span class="badge bg-secondary px-3 py-2 rounded-pill">ملغى</span> @break
                        @endswitch
                    </div>
                    <form method="post" action="{{ route('admin.orders.updateStatus', $order) }}" class="d-flex gap-2">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="form-select form-select-lg">
                            <option value="new" @selected($order->status === 'new')>جديد</option>
                            <option value="processing" @selected($order->status === 'processing')>قيد التجهيز</option>
                            <option value="done" @selected($order->status === 'done')>مكتمل</option>
                            <option value="cancelled" @selected($order->status === 'cancelled')>ملغى</option>
                        </select>
                        <button class="btn btn-primary px-4 fw-bold" type="submit" style="background-color: var(--gp-primary); border: none;">تحديث</button>
                    </form>
                </div>

                <!-- Items Card -->
                <div class="card border-0 shadow-sm p-4 rounded-4">
                    <h5 class="fw-bold mb-3 border-bottom pb-2">المنتجات المطلوبة</h5>
                    @php $items = $order->items ?? []; @endphp
                    @if(empty($items))
                        <div class="text-muted text-center py-3">لا توجد منتجات مسجلة في هذا الطلب.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="bg-light">
                                <tr>
                                    <th class="border-0 rounded-start">المنتج</th>
                                    <th class="border-0">السعر</th>
                                    <th class="border-0">الكمية</th>
                                    <th class="border-0 rounded-end">المجموع</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td class="fw-bold">{{ $item['name'] ?? '' }}</td>
                                        <td class="text-muted">{{ number_format($item['price'] ?? 0, 2) }}</td>
                                        <td class="fw-bold">{{ $item['qty'] ?? 0 }}</td>
                                        <td class="fw-bold text-primary">{{ number_format($item['subtotal'] ?? 0, 2) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot class="border-top">
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold pt-3 h5">الإجمالي الكلي:</td>
                                        <td class="pt-3 fw-bold h5 text-primary">{{ number_format($order->total, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
