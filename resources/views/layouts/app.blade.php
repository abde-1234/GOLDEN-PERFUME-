<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $shopName ?? config('goldenperfume.shop_name') }} - متجر العطور</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/icon.svg') }}">
    <link rel="alternate icon" href="{{ asset('images/logo.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container d-flex align-items-center">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2 me-2" href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Golden Perfume" height="50">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse flex-grow-1 justify-content-center" id="nav">
            <ul class="navbar-nav gap-2">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">الرئيسية</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">المنتجات</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">من نحن</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin*') ? 'active' : '' }}" href="{{ route('admin') }}">الإدارة</a>
                </li>
            </ul>
        </div>
        <div class="d-flex align-items-center gap-3 ms-2">
            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#searchModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg>
            </a>
            <a class="nav-link d-flex align-items-center gap-1" href="{{ route('products.index') }}#cart">
                <div class="position-relative">
                    <span style="font-size: 1.5rem;">🛒</span>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none" id="navCartCount" style="font-size: 0.6rem;">0</span>
                </div>
                <span class="ms-1 d-none d-md-inline">السلة</span>
            </a>
        </div>
    </div>
</nav>

<!-- Search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
            <div class="modal-body p-4">
                <form action="{{ route('products.index') }}" method="GET" class="d-flex gap-2">
<input type="search" name="search" class="form-control form-control-lg" placeholder="ابحث عن عطر..." autofocus>
<button type="submit" class="btn btn-dark">بحث</button>
                </form>
            </div>
        </div>
    </div>
</div>

<main class="container py-4" style="max-width: 1120px;">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</main>

<footer class="py-4">
    <div class="container">
        <div class="row g-3 align-items-start">
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="fw-bold">{{ $shopName ?? config('goldenperfume.shop_name') }}</span>
                </div>
                <div class="small-muted">© {{ date('Y') }} جميع الحقوق محفوظة.</div>
            </div>
            <div class="col-md-4">
                <div class="fw-bold mb-2">روابط سريعة</div>
                <div class="d-flex flex-column gap-2 footer-links">
                    <a href="{{ route('home') }}">الرئيسية</a>
                    <a href="{{ route('products.index') }}">المنتجات</a>
                    <a href="{{ route('about') }}">من نحن</a>
                    <a href="{{ route('admin') }}">الإدارة</a>
                </div>
            </div>
            <div class="col-md-4">
                @php
                    $wa = preg_replace('/\D+/', '', config('goldenperfume.whatsapp_number'));
                @endphp
                <div class="fw-bold mb-2">تواصل معنا</div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span>💬 واتساب:</span>
                    <a class="btn btn-success btn-sm rounded-pill px-3" target="_blank" href="https://wa.me/{{ $wa }}">راسلنا الآن</a>
                </div>
                <div class="small-muted">يمكن تغيير رقم واتساب من ملف .env عبر WHATSAPP_NUMBER.</div>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function(){
    try{
        var KEY='gp_cart_v1';
        var badge=document.getElementById('navCartCount');
        var nav=document.querySelector('.navbar');
        function countCart(){
            if(!badge) return;
            var raw=localStorage.getItem(KEY);
            var sum=0;
            if(raw){
                try{
                    var obj=JSON.parse(raw);
                    for(var k in obj){
                        var v=Number(obj[k])||0;
                        if(v>0) sum+=v;
                    }
                }catch(e){}
            }
            badge.textContent=String(sum);
            badge.classList.toggle('d-none', sum===0);
        }
        function updateScroll(){
            if(!nav) return;
            var y=window.scrollY||document.documentElement.scrollTop||0;
            nav.classList.toggle('scrolled', y>10);
        }
        countCart();
        updateScroll();
        window.addEventListener('storage', function(e){
            if(e.key===KEY) countCart();
        });
        window.addEventListener('scroll', updateScroll, {passive:true});
    }catch(e){}
})();
</script>
@stack('scripts')
</body>
</html>
