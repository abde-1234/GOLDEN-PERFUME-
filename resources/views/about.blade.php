@extends('layouts.app')

@section('content')
    <div class="row align-items-center g-5 my-3">
        <div class="col-lg-6">
            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill mb-3 fw-bold">قصتنا</span>
            <h1 class="display-5 fw-bold mb-4">نحن Golden Perfume <span class="text-primary">.</span></h1>
            <p class="lead text-muted mb-4 leading-relaxed">
                بدأنا بشغف بسيط: أن نجعل العطور الفاخرة في متناول الجميع. نحن لا نبيع مجرد عطور، بل نقدم تجربة تجمع بين الأناقة، الثبات، والسعر المدروس.
            </p>
            
            <div class="d-flex gap-4 mt-5">
                <div class="d-flex flex-column gap-2">
                    <h2 class="h1 fw-bold text-white mb-0">+500</h2>
                    <span class="text-muted small">زبون سعيد</span>
                </div>
                <div class="vr bg-secondary opacity-25"></div>
                <div class="d-flex flex-column gap-2">
                    <h2 class="h1 fw-bold text-white mb-0">100%</h2>
                    <span class="text-muted small">جودة مضمونة</span>
                </div>
                <div class="vr bg-secondary opacity-25"></div>
                <div class="d-flex flex-column gap-2">
                    <h2 class="h1 fw-bold text-white mb-0">24/7</h2>
                    <span class="text-muted small">دعم متواصل</span>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="position-relative">
                <div class="card border-0 shadow-lg p-4 mb-4" style="background: linear-gradient(145deg, #1e293b, #0f172a); transform: rotate(-2deg);">
                    <div class="d-flex align-items-start gap-3">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-gem" viewBox="0 0 16 16">
                                <path d="M3.1.7a.5.5 0 0 1 .4-.2h9a.5.5 0 0 1 .4.2l2.976 3.974c.149.185.156.45.01.644L8.4 15.3a.5.5 0 0 1-.8 0L.1 5.3a.5.5 0 0 1 0-.644L3.1.7z"/>
                            </svg>
                        </div>
                        <div>
                            <h5 class="fw-bold text-white mb-2">رؤيتنا</h5>
                            <p class="text-white-50 small mb-0">أن نكون وجهتك الأولى لكل ما هو عطري، مع تجربة تسوق سلسة تبدأ من تصفح الموقع وتنتهي بابتسامة عند استلام الطلب.</p>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-lg p-4" style="background: rgba(30, 41, 59, 0.6); backdrop-filter: blur(10px); transform: rotate(2deg);">
                    <div class="d-flex align-items-start gap-3">
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                                <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592z"/>
                            </svg>
                        </div>
                        <div>
                            <h5 class="fw-bold text-white mb-2">تواصل مباشر</h5>
                            <p class="text-white-50 small mb-0">نؤمن بالتواصل الإنساني. فريقنا جاهز دائماً للرد على استفساراتك عبر الواتساب، سواء للنصيحة أو للمساعدة في الطلب.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-5">
        <div class="col-md-4">
            <div class="card h-100 p-4 border-0 bg-transparent">
                <div class="mb-3 text-warning display-6">💎</div>
                <h3 class="h5 fw-bold text-white">جودة لا تضاهى</h3>
                <p class="text-muted small">نختار مكونات عطورنا بعناية فائقة لضمان ثبات وفوحان يرضي ذوقك الرفيع.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 p-4 border-0 bg-transparent">
                <div class="mb-3 text-warning display-6">📦</div>
                <h3 class="h5 fw-bold text-white">توصيل سريع</h3>
                <p class="text-muted small">نعلم أنك متشوق لاستلام عطرك، لذا نتعاون مع أفضل شركات التوصيل لضمان وصوله إليك بأسرع وقت.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 p-4 border-0 bg-transparent">
                <div class="mb-3 text-warning display-6">💝</div>
                <h3 class="h5 fw-bold text-white">باقات مميزة</h3>
                <p class="text-muted small">نقدم باقات (Packs) متنوعة تناسب الهدايا أو الاستخدام الشخصي بأسعار تنافسية.</p>
            </div>
        </div>
    </div>

    <div class="mt-5 text-center">
        <p class="text-white-50 mb-3">هل لديك سؤال أو استفسار؟</p>
        <a href="https://wa.me/{{ config('goldenperfume.whatsapp_number', env('WHATSAPP_NUMBER')) }}" target="_blank" class="btn btn-success btn-lg rounded-pill px-5 shadow-lg">
            تحدث معنا على واتساب <i class="bi bi-whatsapp ms-2"></i>
        </a>
    </div>
@endsection

