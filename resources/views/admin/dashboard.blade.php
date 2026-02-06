@extends('layouts.app')

@section('content')
    <div class="admin-hero p-4 p-md-5 mb-5 d-flex flex-column flex-md-row justify-content-between align-items-center gap-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge bg-warning text-dark rounded-pill px-3 py-2">👑 المشرف العام</span>
            </div>
            <h1 class="display-5 fw-bold mb-2">أهلاً بك في لوحة القيادة</h1>
            <p class="lead opacity-75 mb-0" style="max-width: 500px;">هنا يمكنك إدارة متجرك بالكامل، متابعة الطلبات، وتحديث المنتجات بكل سهولة.</p>
        </div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('home') }}" class="btn btn-outline-light rounded-pill px-4" target="_blank">
                <span>👁️ زيارة المتجر</span>
            </a>
            <form method="post" action="{{ route('admin.logout') }}">
                @csrf
                <button class="btn btn-light rounded-pill px-4 text-dark fw-bold" type="submit">تسجيل الخروج</button>
            </form>
        </div>
    </div>

    <div class="admin-layout">
        @include('admin.partials.sidebar')

        <section>
            @if(!empty($stats))
                <div class="row g-4 mb-5">
                    <!-- Orders Stat -->
                    <div class="col-md-4">
                        <div class="stat-card h-100">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="stat-icon orange">🧾</div>
                                    <h3 class="h2 fw-bold mb-1">{{ $stats['orders']['ordersTotal'] }}</h3>
                                    <div class="text-muted small">إجمالي الطلبات</div>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-warning text-dark mb-1">جديد: {{ $stats['orders']['ordersNew'] }}</span>
                                    <div class="small text-success">
                                         مكتمل: {{ $stats['orders']['ordersDone'] }}
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-top border-light-subtle">
                                <a href="{{ route('admin.orders.index') }}" class="text-decoration-none small fw-bold text-primary">عرض التفاصيل &larr;</a>
                            </div>
                        </div>
                    </div>

                    <!-- Products Stat -->
                    <div class="col-md-4">
                        <div class="stat-card h-100">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="stat-icon purple">📦</div>
                                    <h3 class="h2 fw-bold mb-1">{{ $stats['products']['productsTotal'] }}</h3>
                                    <div class="text-muted small">عدد المنتجات</div>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-success text-white mb-1">نشط: {{ $stats['products']['productsActive'] }}</span>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-top border-light-subtle">
                                <a href="{{ route('admin.products.index') }}" class="text-decoration-none small fw-bold text-primary">إدارة المخزون &larr;</a>
                            </div>
                        </div>
                    </div>

                    <!-- Comments Stat -->
                    <div class="col-md-4">
                        <div class="stat-card h-100">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="stat-icon blue">💬</div>
                                    <h3 class="h2 fw-bold mb-1">{{ $stats['comments']['commentsTotal'] }}</h3>
                                    <div class="text-muted small">آراء العملاء</div>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-info text-dark mb-1">ظاهر: {{ $stats['comments']['commentsVisible'] }}</span>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-top border-light-subtle">
                                <a href="{{ route('admin.comments.index') }}" class="text-decoration-none small fw-bold text-primary">مراجعة التعليقات &larr;</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <h4 class="fw-bold mb-3">⚡ إجراءات سريعة</h4>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="dashboard-card p-4 h-100">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-bag-plus" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 7.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0v-1.5H6a.5.5 0 0 1 0-1h1.5V8a.5.5 0 0 1 .5-.5z"/>
                                    <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>
                                </svg>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">إضافة منتج جديد</h5>
                                <p class="text-muted small mb-0">أضف عطور جديدة للمتجر.</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-outline-dark rounded-pill w-100">ابدأ الإضافة</a>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="dashboard-card p-4 h-100">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-file-earmark-spreadsheet" viewBox="0 0 16 16">
                                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5v2zM3 12v-2h10v2H3z"/>
                                </svg>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">تصدير الطلبات</h5>
                                <p class="text-muted small mb-0">تحميل جميع الطلبات كملف CSV.</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.orders.export') }}" class="btn btn-outline-dark rounded-pill w-100">تحميل التقرير</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
