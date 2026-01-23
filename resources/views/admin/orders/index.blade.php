@extends('layouts.app')

@section('content')
    <div class="admin-layout">
        <aside class="admin-sidebar">
            <div class="fw-bold mb-2">إدارة المتجر</div>
            <ul class="nav flex-column gap-1">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin') ? 'active' : '' }}" href="{{ route('admin') }}"><span>🏠</span> <span class="label">لوحة الإدارة</span></a></li>
                <li class="nav-item"><a class="nav-link active" href="{{ route('admin.orders.index') }}"><span>🧾</span> <span class="label">الطلبات</span></a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.products.index') }}"><span>📦</span> <span class="label">المنتجات</span></a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.comments.index') }}"><span>💬</span> <span class="label">التعليقات</span></a></li>
            </ul>
        </aside>
        <section>
            <div class="admin-topbar d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-outline-dark btn-sm rounded-pill" type="button" id="toggleSidebarBtn">☰</button>
                    <h1 class="h5 fw-bold mb-0">الطلبات</h1>
                    <span class="badge bg-dark text-light">الإجمالي: {{ $orders->total() }}</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-dark btn-sm rounded-pill px-3">+ إضافة منتج</a>
                    <a href="{{ route('admin.orders.export', request()->query()) }}" class="btn btn-outline-dark btn-sm rounded-pill px-3">تصدير CSV</a>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge text-bg-success">موثّق</span>
                        <span class="small-muted">المدير</span>
                    </div>
                </div>
            </div>

            <form method="get" class="card border-0 shadow-sm p-3 mb-3">
                <div class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small">الحالة</label>
                        <select name="status" class="form-select">
                            <option value="">الكل</option>
                            <option value="new" @selected(request('status')==='new')>جديد</option>
                            <option value="processing" @selected(request('status')==='processing')>قيد التجهيز</option>
                            <option value="done" @selected(request('status')==='done')>مكتمل</option>
                            <option value="cancelled" @selected(request('status')==='cancelled')>ملغى</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small">بحث</label>
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" value="{{ request('q') }}" placeholder="الاسم أو الهاتف">
                            <button class="btn btn-outline-dark" type="submit">بحث</button>
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">مسح</a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">نطاق التاريخ</label>
                        <div class="d-flex gap-2">
                            <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                            <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small">عدد الصفوف</label>
                        <select name="per_page" class="form-select" onchange="this.form.submit()">
                            @foreach([10,25,50] as $pp)
                                <option value="{{ $pp }}" @selected((int)request('per_page', 10) === $pp)>{{ $pp }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>

            <div class="card border-0 shadow-sm p-3">
                @if($orders->isEmpty())
                    <div class="text-muted">لا توجد طلبات بعد.</div>
                @else
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="small-muted">عرض {{ $orders->count() }} من {{ $orders->total() }}</div>
                        <div></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>الزبون</th>
                                <th>الهاتف</th>
                                <th>الإجمالي</th>
                                <th>الحالة</th>
                                <th>تاريخ الإنشاء</th>
                                <th style="width:120px;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->customer_name }}</td>
                                    <td>{{ $order->customer_phone }}</td>
                                    <td>{{ number_format($order->total, 2) }}</td>
                                    <td>
                                        @switch($order->status)
                                            @case('new') <span class="badge text-bg-warning">جديد</span> @break
                                            @case('processing') <span class="badge text-bg-info">قيد التجهيز</span> @break
                                            @case('done') <span class="badge text-bg-success">مكتمل</span> @break
                                            @case('cancelled') <span class="badge text-bg-secondary">ملغى</span> @break
                                            @default {{ $order->status }}
                                        @endswitch
                                    </td>
                                    <td>{{ $order->created_at?->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-dark rounded-pill px-3">عرض</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $orders->onEachSide(1)->links() }}
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection

@push('scripts')
<script>
(function(){
  var root = document.querySelector('.admin-layout');
  var btn = document.getElementById('toggleSidebarBtn');
  var KEY='adminSidebarCollapsed';
  try{
    var collapsed = localStorage.getItem(KEY)==='1';
    if(collapsed){ root?.classList.add('collapsed'); }
    btn?.addEventListener('click', function(){
      root?.classList.toggle('collapsed');
      var isCollapsed = root?.classList.contains('collapsed');
      localStorage.setItem(KEY, isCollapsed ? '1' : '0');
    });
  }catch(e){}
})();
</script>
@endpush
