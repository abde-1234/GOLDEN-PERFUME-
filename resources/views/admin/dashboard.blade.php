@extends('layouts.app')

@section('content')
    <div class="admin-hero p-4 p-md-5 mb-4 rounded-4 text-white d-flex justify-content-between align-items-center">
        <div>
            <h1 class="display-6 fw-bold mb-2">لوحة الإدارة</h1>
            <div class="d-flex flex-wrap gap-2">
                <span class="badge bg-white/10 text-white border border-white/20">🗂️ إدارة المحتوى</span>
                <span class="badge bg-white/10 text-white border border-white/20">📦 المنتجات</span>
                <span class="badge bg-white/10 text-white border border-white/20">💬 التعليقات</span>
                <span class="badge bg-white/10 text-white border border-white/20">🧾 الطلبات</span>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-light rounded-pill" type="button" id="toggleSidebarBtn">☰</button>
            <form method="post" action="{{ route('admin.logout') }}">
                @csrf
                <button class="btn btn-outline-light rounded-pill" type="submit">تسجيل الخروج</button>
            </form>
        </div>
    </div>

    @if(!empty($stats))
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-4 stat-card h-100">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="fw-bold d-flex align-items-center gap-2"><span>🧾</span><span>الطلبات</span></div>
                        <span class="badge bg-dark text-light">المجموع: {{ $stats['orders']['ordersTotal'] }}</span>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge text-bg-warning">جديد: {{ $stats['orders']['ordersNew'] }}</span>
                        <span class="badge text-bg-info">قيد التجهيز: {{ $stats['orders']['ordersProcessing'] }}</span>
                        <span class="badge text-bg-success">مكتمل: {{ $stats['orders']['ordersDone'] }}</span>
                        <span class="badge text-bg-secondary">ملغى: {{ $stats['orders']['ordersCancelled'] }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-4 stat-card h-100">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="fw-bold d-flex align-items-center gap-2"><span>📦</span><span>المنتجات</span></div>
                        <span class="badge bg-dark text-light">المجموع: {{ $stats['products']['productsTotal'] }}</span>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge text-bg-success">مفعل: {{ $stats['products']['productsActive'] }}</span>
                        <span class="badge text-bg-secondary">مخفي: {{ $stats['products']['productsTotal'] - $stats['products']['productsActive'] }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-4 stat-card h-100">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="fw-bold d-flex align-items-center gap-2"><span>💬</span><span>التعليقات</span></div>
                        <span class="badge bg-dark text-light">المجموع: {{ $stats['comments']['commentsTotal'] }}</span>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge text-bg-success">ظاهر: {{ $stats['comments']['commentsVisible'] }}</span>
                        <span class="badge text-bg-secondary">مخفي: {{ $stats['comments']['commentsTotal'] - $stats['comments']['commentsVisible'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="admin-layout">
        <aside class="admin-sidebar">
            <div class="fw-bold mb-2">إدارة المتجر</div>
            <ul class="nav flex-column gap-1">
                <li class="nav-item"><a class="nav-link active" href="{{ route('admin') }}"><span>🏠</span> <span class="label">لوحة الإدارة</span></a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.orders.index') }}"><span>🧾</span> <span class="label">الطلبات</span></a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.products.index') }}"><span>📦</span> <span class="label">المنتجات</span></a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.comments.index') }}"><span>💬</span> <span class="label">التعليقات</span></a></li>
            </ul>
        </aside>
        <section>
    <div class="row g-3">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4 h-100">
                <div class="d-flex align-items-start gap-3">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-speedometer" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5v4.17l2.2 1.27a.5.5 0 1 1-.5.86L7.5 9.21V4.5A.5.5 0 0 1 8 4"/>
                            <path d="M8 0a8 8 0 1 0 8 8A8 8 0 0 0 8 0M1.05 8a6.95 6.95 0 1 1 13.9 0 6.95 6.95 0 0 1-13.9 0"/>
                        </svg>
                    </div>
                    <div>
                        <div class="fw-bold mb-1">نظرة عامة</div>
                        <div class="small-muted">تحكم بالمنتجات والتعليقات والطلبات من مكان واحد.</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="fw-bold mb-1 d-flex align-items-center gap-2"><span>🧾</span><span>الطلبات</span></div>
                    <div class="small-muted mb-2">استقبال طلبات الزبناء من الموقع وتتبع حالتها.</div>
                </div>
                <div>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-dark btn-sm">فتح إدارة الطلبات</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="fw-bold mb-1 d-flex align-items-center gap-2"><span>📦</span><span>إدارة المنتجات</span></div>
                    <div class="small-muted mb-2">إضافة، تعديل، أو حذف المنتجات الظاهرة في المتجر.</div>
                </div>
                <div>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-dark rounded-pill px-3 btn-sm">فتح إدارة المنتجات</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="fw-bold mb-1 d-flex align-items-center gap-2"><span>💬</span><span>إدارة التعليقات</span></div>
                    <div class="small-muted mb-2">مراجعة تعاليق الزبناء، إخفاؤها عن الموقع أو حذفها نهائياً.</div>
                </div>
                <div>
                    <a href="{{ route('admin.comments.index') }}" class="btn btn-outline-dark rounded-pill px-3 btn-sm">فتح إدارة التعليقات</a>
                </div>
            </div>
        </div>
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
