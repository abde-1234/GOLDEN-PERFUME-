<aside class="admin-sidebar">
    <div class="d-flex align-items-center gap-2 mb-4 px-2">
        <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">⚡</div>
        <div class="fw-bold fs-5">القائمة الرئيسية</div>
    </div>
    
    <ul class="nav flex-column gap-1">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin') ? 'active' : '' }}" href="{{ route('admin') }}">
                <span>📊</span>
                <span class="label">نظرة عامة</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                <span>🧾</span>
                <span class="label">الطلبات</span>
                @if(isset($stats['orders']['ordersNew']) && $stats['orders']['ordersNew'] > 0)
                    <span class="badge bg-danger rounded-pill ms-auto">{{ $stats['orders']['ordersNew'] }}</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                <span>📦</span>
                <span class="label">المنتجات</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.comments.*') ? 'active' : '' }}" href="{{ route('admin.comments.index') }}">
                <span>💬</span>
                <span class="label">التعليقات</span>
            </a>
        </li>
    </ul>

    <div class="mt-4 px-2">
        <div class="small text-muted fw-bold mb-2">روابط سريعة</div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary w-100 rounded-pill py-2 text-dark fw-bold mb-3" style="background-color: var(--gp-primary); border: none;">
            + إضافة منتج
        </a>
        
        <form method="post" action="{{ route('admin.logout') }}">
            @csrf
            <button class="btn btn-light w-100 rounded-pill py-2 text-danger fw-bold border" type="submit">تسجيل الخروج</button>
        </form>
    </div>
</aside>