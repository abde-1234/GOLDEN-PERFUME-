@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4 section-title mb-1">تفاصيل الطلب #{{ $order->id }}</h1>
            <div class="small-muted">تم إنشاء الطلب بتاريخ {{ $order->created_at?->format('Y-m-d H:i') }}</div>
        </div>
        <form method="post" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطلب؟');">
            @csrf
            @method('DELETE')
            <button class="btn btn-outline-danger btn-sm" type="submit">حذف الطلب</button>
        </form>
    </div>

    <div class="row g-3">
        <div class="col-md-5">
            <div class="card p-3">
                <div class="fw-bold mb-2">معلومات الزبون</div>
                <div class="small-muted mb-1">الاسم: {{ $order->customer_name }}</div>
                <div class="small-muted mb-1">الهاتف: {{ $order->customer_phone }}</div>
                <div class="small-muted mb-1">العنوان: {{ $order->customer_address }}</div>
                @if($order->customer_note)
                    <div class="small-muted mb-1">ملاحظة: {{ $order->customer_note }}</div>
                @endif
            </div>

            <div class="card p-3 mt-3">
                <div class="fw-bold mb-2">حالة الطلب</div>
                <form method="post" action="{{ route('admin.orders.updateStatus', $order) }}">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="form-select form-select-sm mb-2">
                        <option value="new" @selected($order->status === 'new')>جديد</option>
                        <option value="processing" @selected($order->status === 'processing')>قيد التجهيز</option>
                        <option value="done" @selected($order->status === 'done')>مكتمل</option>
                        <option value="cancelled" @selected($order->status === 'cancelled')>ملغى</option>
                    </select>
                    <button class="btn btn-dark btn-sm" type="submit">تحديث الحالة</button>
                </form>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card p-3">
                <div class="fw-bold mb-2">المنتجات في الطلب</div>
                @php
                    $items = $order->items ?? [];
                @endphp
                @if(empty($items))
                    <div class="text-muted">لا توجد منتجات مسجلة في هذا الطلب.</div>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                            <tr>
                                <th>المنتج</th>
                                <th>السعر</th>
                                <th>الكمية</th>
                                <th>المجموع</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item['name'] ?? '' }}</td>
                                    <td>{{ number_format($item['price'] ?? 0, 2) }}</td>
                                    <td>{{ $item['qty'] ?? 0 }}</td>
                                    <td>{{ number_format($item['subtotal'] ?? 0, 2) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="fw-bold mt-2">الإجمالي: {{ number_format($order->total, 2) }}</div>
                @endif
            </div>
        </div>
    </div>
@endsection

