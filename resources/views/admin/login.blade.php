@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-center py-5" style="min-height: 80vh;">
    <div class="col-md-6 col-lg-4">
        <div class="text-center mb-4">
            <div class="mb-3">
                <span class="bg-warning bg-opacity-10 text-warning p-3 rounded-circle d-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-shield-lock" viewBox="0 0 16 16">
                        <path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z"/>
                        <path d="M9.5 6.5a1.5 1.5 0 0 1-1 1 1 1 0 0 1-1-1 1 1 0 0 1 1-1 1 1 0 0 1 1 1zm-3 0a3 3 0 1 1 6 0 3 3 0 0 1-6 0z"/>
                    </svg>
                </span>
            </div>
            <h1 class="h3 fw-bold mb-2">تسجيل دخول الأدمن</h1>
            <p class="text-muted">يرجى إدخال بيانات الدخول للمتابعة.</p>
        </div>

        <div class="card border-0 shadow-lg p-4 p-md-5 rounded-4 bg-white">
            <form method="post" action="{{ route('admin.login.submit') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">البريد الإلكتروني</label>
                    <input name="email" type="email" class="form-control form-control-lg bg-light border-0" value="{{ old('email') }}" required autofocus placeholder="admin@example.com">
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold small text-muted">الكود السري</label>
                    <input name="code" type="password" class="form-control form-control-lg bg-light border-0" required placeholder="••••••••">
                </div>
                <button class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-sm mb-3" type="submit" style="background-color: var(--gp-primary); border: none; color: #0b1120;">
                    تسجيل الدخول
                </button>
            </form>
        </div>
        
        <div class="text-center mt-4">
             <a href="{{ route('home') }}" class="text-decoration-none text-muted small fw-bold hover-underline">&larr; العودة للمتجر</a>
        </div>
    </div>
</div>
@endsection
