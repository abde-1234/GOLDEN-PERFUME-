@extends('layouts.app')

@section('content')
    <div class="admin-hero p-4 p-md-5 mb-4 rounded-4 text-white">
        <div class="d-flex flex-column align-items-center text-center">
            <h1 class="display-6 fw-bold mb-2">تسجيل دخول الأدمن</h1>
            <p class="text-white-50 mb-0">دخول آمن للوصول إلى لوحة الإدارة</p>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg p-4" style="background: rgba(30, 41, 59, 0.6); backdrop-filter: blur(12px);">
                <form method="post" action="{{ route('admin.login.submit') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">البريد الإلكتروني</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark text-white border-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v.217l-8 4.8-8-4.8z"/>
                                    <path d="M0 6.383V12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6.383l-7.555 4.533a1 1 0 0 1-1.11 0z"/>
                                </svg>
                            </span>
                            <input name="email" type="email" class="form-control bg-dark text-white border-secondary" value="{{ old('email') }}" required autofocus placeholder="admin@example.com">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الكود السري</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark text-white border-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-shield-lock" viewBox="0 0 16 16">
                                    <path d="M5.5 10a1.5 1.5 0 1 0 3 0 1.5 1.5 0 0 0-3 0"/>
                                    <path d="M7.5 1.018a.5.5 0 0 1 .5 0l4.5 2.4a.5.5 0 0 1 .268.445c-.007 3.026-.533 5.852-4.063 7.86a.5.5 0 0 1-.41 0C4.764 9.715 4.238 6.89 4.23 3.863a.5.5 0 0 1 .268-.445z"/>
                                </svg>
                            </span>
                            <input name="code" type="password" class="form-control bg-dark text-white border-secondary" required placeholder="••••••••">
                        </div>
                    </div>
                    <button class="btn btn-primary w-100 rounded-pill fw-bold" type="submit" style="background-color: var(--gp-primary); border: none; color: #0b1120;">دخول</button>
                </form>
                <div class="small-muted mt-3">
                    إذا واجهت مشكلة في الدخول، تأكد من ضبط متغيرات البيئة ADMIN_EMAIL(S) و ADMIN_CODE.
                </div>
            </div>
        </div>
    </div>
@endsection
