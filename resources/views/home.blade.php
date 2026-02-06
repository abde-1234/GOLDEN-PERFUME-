@extends('layouts.app')

@section('content')
    <div class="hero position-relative overflow-hidden p-4 p-md-5 d-flex flex-column justify-content-center align-items-center text-center mb-5">
        <!-- Vertical Background Slider -->
        <div class="hero-slider">
            <div class="hero-slide" style="background-image: url('{{ asset('images/hero.png') }}')"></div>
            <div class="hero-slide" style="background-image: url('{{ asset('images/blue-green-grass.png') }}')"></div>
            <div class="hero-slide" style="background-image: url('{{ asset('images/blue-green-tree.png') }}')"></div>
            <div class="hero-slide" style="background-image: url('{{ asset('images/black-rock.png') }}')"></div>
            <!-- Duplicate first slide for seamless loop -->
            <div class="hero-slide" style="background-image: url('{{ asset('images/hero.png') }}')"></div>
        </div>
        
        <!-- Dark Overlay with Gradient -->
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.5) 100%); z-index: 1;"></div>

        <div class="col-lg-8 position-relative" style="z-index: 2;">
            <div class="mb-4">
                <span class="badge bg-white/10 text-white border border-white/20 px-4 py-2 rounded-pill backdrop-blur-sm" style="backdrop-filter: blur(4px); background-color: rgba(255,255,255,0.1);">✨ متجر عطور مغربي فاخر</span>
            </div>
            <h1 class="display-3 fw-bold mb-4 text-white" style="text-shadow: 0 2px 10px rgba(0,0,0,0.5); letter-spacing: -1px;">فخامة الحضور..<br><span class="text-warning position-relative">في كل رشة</span></h1>
            <p class="lead mb-5 mx-auto text-white-50 fw-light" style="max-width: 650px; font-size: 1.25rem; line-height: 1.8;">
                اكتشف تشكيلة <b class="text-white">Golden Perfume</b> الحصرية. ثبات يدوم طويلاً، روائح تأسر الحواس، وأسعار صممت لتناسب ذوقك الرفيع.
            </p>
            
            <div class="d-flex flex-wrap justify-content-center gap-3 gap-md-5 mb-5 small text-white opacity-75">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-truck fs-5"></i>
                    <span class="fw-medium">توصيل سريع</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-whatsapp fs-5"></i>
                    <span class="fw-medium">طلب عبر واتساب</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-star-fill fs-5"></i>
                    <span class="fw-medium">جودة مضمونة</span>
                </div>
            </div>

            <a href="{{ route('products.index') }}" class="btn btn-warning btn-lg px-5 py-3 rounded-pill fw-bold shadow-lg text-dark border-0 hover-scale" style="transition: transform 0.2s;">
                اطلب عطرك الآن
            </a>
        </div>
    </div>



    <div class="row g-4 mt-2">
        <div class="col-md-4">
            <div class="card p-4 h-100 text-center border-0">
                <div class="mb-3 d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 64px; height: 64px; background: rgba(245, 158, 11, 0.1); color: var(--gp-primary);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-gem" viewBox="0 0 16 16">
                        <path d="M3.1.7a.5.5 0 0 1 .4-.2h9a.5.5 0 0 1 .4.2l2.976 3.974c.149.185.156.45.01.644L8.4 15.3a.5.5 0 0 1-.8 0L.1 5.3a.5.5 0 0 1 0-.644zm11.355 4 2 2.667L15.633 4.7H14.455zm-.966 0h-2.11L8 1.15 4.621 4.7h-2.11l2.334 3.112L8 14.04l3.155-6.228zm-3.834 0L8 2.667l-1.655 2.033zm.966 0L8 12.333l-2.655-7.633z"/>
                    </svg>
                </div>
                <h3 class="h5 fw-bold mb-2">تشكيلة مميزة</h3>
                <p class="small-muted mb-0">عطور فردية وباكات (Le Pack) تجمع بين الأناقة والتوفير، لتناسب ذوقك وميزانيتك.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 h-100 text-center border-0">
                <div class="mb-3 d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 64px; height: 64px; background: rgba(245, 158, 11, 0.1); color: var(--gp-primary);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
                        <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                        <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9 9 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.4 10.4 0 0 1-.502 1.21c-.428.977-1.08 1.436-1.518 1.735a.5.5 0 0 0 .02.92zM8 1a7.001 7.001 0 0 1 5.426 7.034c-.732.078-1.535.16-2.374.24a.5.5 0 0 0-.05.992c.966-.091 1.874-.19 2.66-.282A7.001 7.001 0 0 1 8 15c-3.37 0-6.285-1.92-7.23-4.52.938-.59 1.758-1.295 2.418-2.077a.5.5 0 1 0-.762-.646 6.002 6.002 0 0 0-1.84 2.158A6.99 6.99 0 0 1 1 8c0-3.866 3.582-7 8-7"/>
                    </svg>
                </div>
                <h3 class="h5 fw-bold mb-2">سهولة الطلب</h3>
                <p class="small-muted mb-0">اطلب مباشرة عبر واتساب، أو أرسل طلبك من الموقع وسنتواصل معك فوراً للتأكيد.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 h-100 text-center border-0">
                <div class="mb-3 d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 64px; height: 64px; background: rgba(245, 158, 11, 0.1); color: var(--gp-primary);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-wallet2" viewBox="0 0 16 16">
                        <path d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5z"/>
                    </svg>
                </div>
                <h3 class="h5 fw-bold mb-2">الدفع والتوصيل</h3>
                <p class="small-muted mb-0">ادفع عند الاستلام. نوفر خدمة التوصيل السريع لجميع المدن المغربية.</p>
            </div>
        </div>
    </div>

    <div class="d-flex align-items-end justify-content-between mt-5 mb-4">
        <h2 class="h3 fw-bold mb-0">✨ منتجات مختارة لك</h2>
        <a class="btn btn-outline-dark rounded-pill px-4" href="{{ route('products.index') }}">تصفح الكل</a>
    </div>



    <div id="homeTabBest">
    <div class="row g-4">
        @forelse($featuredProducts as $p)
            <div class="col-md-4">
                <div class="card overflow-hidden h-100 border-0 shadow-sm" style="transition: transform 0.2s;">
                    <div class="position-relative bg-white d-flex align-items-center justify-content-center" style="height: 320px; border-bottom: 1px solid rgba(0,0,0,0.03);">
                        <img src="{{ $p->image_path ? asset($p->image_path) : asset('images/logo.png') }}" 
                             alt="{{ $p->name }}" 
                             style="max-height: 85%; max-width: 85%; object-fit: contain;">
                        <span class="position-absolute top-0 end-0 m-3 badge {{ $p->category === 'pack' ? 'bg-warning text-dark' : 'bg-dark text-white' }} px-3 py-2 rounded-pill shadow-sm">
                            {{ $p->category === 'pack' ? 'Le Pack' : 'عطر' }}
                        </span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h3 class="h5 fw-bold mb-1">{{ $p->name }}</h3>
                        <p class="small text-muted mb-3 flex-grow-1">{{ $p->short_description }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top border-light-subtle">
                            <div class="fw-bold fs-5 text-primary">{{ number_format($p->price, 2) }} {{ $currency }}</div>
                            <a href="{{ route('products.index') }}" class="btn btn-dark rounded-pill px-4">اطلب الآن</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info bg-dark-subtle border-0 text-white">لا توجد منتجات بعد.</div>
            </div>
        @endforelse
    </div>
    </div>



    <div class="row g-5 mt-5 align-items-start">
        <div class="col-lg-5 order-lg-last">
            <div class="card border-0 shadow-lg p-4">
                <h3 class="h4 fw-bold mb-4">✍️ شاركنا تجربتك</h3>
                <form method="post" action="{{ route('comments.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">الاسم الكريم</label>
                        <input name="name" class="form-control" value="{{ old('name') }}" placeholder="مثال: محمد" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">تقييمك</label>
                        <select name="rating" class="form-select">
                            <option value="5" selected>⭐⭐⭐⭐⭐ (5/5)</option>
                            <option value="4">⭐⭐⭐⭐ (4/5)</option>
                            <option value="3">⭐⭐⭐ (3/5)</option>
                            <option value="2">⭐⭐ (2/5)</option>
                            <option value="1">⭐ (1/5)</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">رأيك يهمنا</label>
                        <textarea name="message" class="form-control" rows="4" placeholder="كيف كانت تجربتك مع عطورنا؟" required>{{ old('message') }}</textarea>
                    </div>
                    <button class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow-sm" style="background-color: var(--gp-primary); border: none; color: #000;">نشر التعليق</button>
                </form>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 fw-bold mb-0">💬 آراء عملائنا</h2>
                <span class="badge bg-light text-dark border px-3 py-1 rounded-pill">{{ $comments->count() }} تعليق</span>
            </div>

            <div class="d-flex flex-column gap-3">
                @forelse($comments as $c)
                    <div class="card border-0 shadow-sm p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center fw-bold text-dark" style="width: 48px; height: 48px; font-size: 1.2rem;">
                                    {{ mb_substr($c->name, 0, 1) }}
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0">{{ $c->name }}</h5>
                                    <small class="text-muted">{{ $c->created_at?->diffForHumans() }}</small>
                                </div>
                            </div>
                            @if($c->rating)
                                <div class="text-warning fs-5">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $c->rating) ★ @else <span class="text-secondary opacity-50">★</span> @endif
                                    @endfor
                                </div>
                            @endif
                        </div>
                        <p class="mb-0 text-muted leading-relaxed">{{ $c->message }}</p>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <div class="mb-3 text-muted" style="font-size: 3rem;">💭</div>
                        <h4 class="h5">لا توجد تعليقات حتى الآن</h4>
                        <p class="text-muted">كن أول من يشاركنا رأيه في منتجاتنا!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection


