@extends('layouts.app')

@section('content')
    <div class="admin-layout">
        @include('admin.partials.sidebar')

        <section>
            <div class="admin-hero p-4 mb-4 d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 fw-bold mb-2">إدارة الطلبات</h1>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-white bg-opacity-25 text-white border border-white border-opacity-25">🧾 الإجمالي: {{ $orders->total() }}</span>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.orders.export', request()->query()) }}" class="btn btn-light rounded-pill px-4 fw-bold text-dark">
                        ⬇ تصدير CSV
                    </a>
                </div>
            </div>

            <form method="get" class="card border-0 shadow-sm p-4 rounded-4 mb-4">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted">الحالة</label>
                        <select name="status" class="form-select border-light bg-light">
                            <option value="">الكل</option>
                            <option value="new" @selected(request('status')==='new')>جديد</option>
                            <option value="processing" @selected(request('status')==='processing')>قيد التجهيز</option>
                            <option value="done" @selected(request('status')==='done')>مكتمل</option>
                            <option value="cancelled" @selected(request('status')==='cancelled')>ملغى</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-muted">بحث</label>
                        <div class="input-group">
                            <input type="text" name="q" class="form-control border-light bg-light" value="{{ request('q') }}" placeholder="الاسم أو الهاتف">
                            <button class="btn btn-primary" type="submit">بحث</button>
                            @if(request('q') || request('status') || request('from') || request('to'))
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">مسح</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted">نطاق التاريخ</label>
                        <div class="d-flex gap-2">
                            <input type="date" name="from" class="form-control border-light bg-light" value="{{ request('from') }}">
                            <input type="date" name="to" class="form-control border-light bg-light" value="{{ request('to') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-bold text-muted">عدد الصفوف</label>
                        <select name="per_page" class="form-select border-light bg-light" onchange="this.form.submit()">
                            @foreach([10,25,50] as $pp)
                                <option value="{{ $pp }}" @selected((int)request('per_page', 10) === $pp)>{{ $pp }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>

            <div class="card border-0 shadow-sm p-3 rounded-4">
                @if($orders->isEmpty())
                    <div class="text-muted p-4 text-center">لا توجد طلبات بعد.</div>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle table-hover mb-0">
                            <thead class="bg-light">
                            <tr>
                                <th class="border-0 rounded-start">#</th>
                                <th class="border-0">الزبون</th>
                                <th class="border-0">الهاتف</th>
                                <th class="border-0">الإجمالي</th>
                                <th class="border-0">الحالة</th>
                                <th class="border-0">تاريخ الإنشاء</th>
                                <th class="border-0 rounded-end" style="width:120px;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td class="fw-bold text-muted">{{ $order->id }}</td>
                                    <td class="fw-bold">{{ $order->customer_name }}</td>
                                    <td>{{ $order->customer_phone }}</td>
                                    <td class="fw-bold text-primary">{{ number_format($order->total, 2) }}</td>
                                    <td>
                                        @switch($order->status)
                                            @case('new') <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">جديد</span> @break
                                            @case('processing') <span class="badge bg-info text-dark px-3 py-2 rounded-pill">قيد التجهيز</span> @break
                                            @case('done') <span class="badge bg-success px-3 py-2 rounded-pill">مكتمل</span> @break
                                            @case('cancelled') <span class="badge bg-secondary px-3 py-2 rounded-pill">ملغى</span> @break
                                            @default {{ $order->status }}
                                        @endswitch
                                    </td>
                                    <td class="text-muted small">{{ $order->created_at?->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-light border rounded-pill px-3 fw-bold text-primary">عرض</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 px-2">
                        {{ $orders->onEachSide(1)->links() }}
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection
