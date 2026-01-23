@extends('layouts.app')

@section('content')
    <div class="products-hero d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 p-4 mb-3">
        <div>
            <h1 class="display-6 fw-bold mb-2">منتجاتنا</h1>
            <div class="d-flex flex-wrap gap-2">
                <span class="badge bg-dark-subtle text-light">🛵 توصيل سريع</span>
                <span class="badge bg-dark-subtle text-light">🛡️ ضمان الجودة</span>
                <span class="badge bg-dark-subtle text-light">💬 دعم واتساب</span>
            </div>
        </div>
        <a href="{{ route('home') }}" class="btn btn-outline-dark rounded-pill">رجوع للرئيسية</a>
    </div>

    <div class="card border-0 shadow-sm p-3 mt-2 filter-bar">
        <div class="d-flex flex-wrap gap-2 align-items-center">
            <div class="fw-bold">تصفية:</div>
            <button class="btn btn-sm btn-dark rounded-pill" data-filter="all" type="button">✨ الكل</button>
            <button class="btn btn-sm btn-outline-dark rounded-pill" data-filter="perfume" type="button">🌸 العطور</button>
            <button class="btn btn-sm btn-outline-dark rounded-pill" data-filter="pack" type="button">🎁 Le Pack</button>
            <div class="ms-auto text-end">
                <div class="small-muted">إجمالي المنتجات: {{ $products->count() }}</div>
                <div class="small-muted">رقم واتساب الحالي: <b>{{ $whatsappNumber }}</b></div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-1" id="productsGrid">
        @foreach($products as $p)
            <div class="col-md-4 product-card" data-category="{{ $p->category }}">
                <div class="card overflow-hidden h-100 border-0 shadow-sm" style="transition: transform 0.2s;">
                    <div class="position-relative">
                        <img src="{{ asset($p->image_path) }}" alt="{{ $p->name }}" class="w-100" style="height:280px; object-fit:cover;">
                        <span class="position-absolute top-0 end-0 m-3 badge {{ $p->category === 'pack' ? 'bg-warning text-dark' : 'bg-dark text-white' }} px-3 py-2 rounded-pill">
                            {{ $p->category === 'pack' ? 'Le Pack' : 'عطر' }}
                        </span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h3 class="h5 fw-bold mb-1">{{ $p->name }}</h3>
                        <p class="small text-muted mb-3 flex-grow-1">{{ $p->short_description }}</p>

                        <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top border-light-subtle">
                            <div class="fw-bold fs-5 text-primary">{{ number_format($p->price, 2) }} {{ $currency }}</div>
                            <button class="btn btn-dark rounded-pill px-4" type="button" data-add-to-cart="{{ $p->id }}">
                                <span>أضف للسلة</span>
                                <span class="ms-1">+</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-4 mt-5">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4 cart-card" id="cart">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h5 section-title mb-0">🛒 سلة المشتريات</h2>
                    <span class="badge bg-dark text-light rounded-pill">المجموع: <span id="cartTotalHeader">0.00</span> {{ $currency }}</span>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="table-light">
                        <tr>
                            <th class="border-0 rounded-start">🧴 المنتج</th>
                            <th class="border-0 text-center" style="width:160px;">🔢 الكمية</th>
                            <th class="border-0 text-end" style="width:120px;">💵 السعر</th>
                            <th class="border-0 rounded-end text-center" style="width:60px;"></th>
                        </tr>
                        </thead>
                        <tbody id="cartBody" class="border-top-0">
                            <tr><td colspan="4" class="text-center py-5 text-muted">السلة فارغة.</td></tr>
                        </tbody>
                        <tfoot class="border-top">
                            <tr>
                                <td colspan="2" class="fw-bold text-end pt-3">الإجمالي:</td>
                                <td class="fw-bold text-end pt-3 fs-5 text-primary"><span id="cartTotal">0.00</span> {{ $currency }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-end">الخصم:</td>
                                <td class="text-end text-success">- <span id="cartDiscount">0.00</span> {{ $currency }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-end">رسوم التوصيل:</td>
                                <td class="text-end"><span id="cartShipping">0.00</span> {{ $currency }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="fw-bold text-end">الإجمالي بعد الخصم:</td>
                                <td class="fw-bold text-end fs-5"><span id="cartGrandTotal">0.00</span> {{ $currency }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div class="text-end mt-2">
                    <button class="btn btn-outline-danger btn-sm rounded-pill px-3" type="button" id="clearCartBtn">🗑️ إفراغ السلة</button>
                </div>
                
                <div class="mt-3 d-flex align-items-center gap-2">
                    <input id="promoCodeInput" class="form-control" placeholder="أدخل كود الخصم (مثال: GP10)" style="max-width: 260px;">
                    <button class="btn btn-outline-dark rounded-pill" type="button" id="applyPromoBtn">تطبيق الخصم</button>
                    <span class="small-muted">أكواد متاحة: GP10 (10%)، GP5 (5%)، WELCOME10 (-10)</span>
                </div>
                <div class="small-muted mt-2">
                    التوصيل: مجاني إذا تجاوز الإجمالي {{ number_format((float) config('goldenperfume.free_shipping_threshold'), 2) }} {{ $currency }}. رسوم التوصيل القياسية {{ number_format((float) config('goldenperfume.shipping_fee'), 2) }} {{ $currency }}.
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4 sticky-top form-card" style="top: 100px; z-index: 1020;">
                <h2 class="h5 section-title mb-3">📦 إتمام الطلب</h2>
                <div class="small-muted mb-4">أدخل بيانات التوصيل.</div>

                <div class="mb-2">
                    <label class="form-label">👤 الاسم</label>
                    <input id="custName" class="form-control" placeholder="الاسم الكامل">
                </div>
                <div class="mb-2">
                    <label class="form-label">📞 الهاتف</label>
                    <input id="custPhone" class="form-control" placeholder="06xxxxxxxx">
                </div>
                <div class="mb-2">
                    <label class="form-label">🏠 المدينة/العنوان</label>
                    <input id="custAddress" class="form-control" placeholder="مثال: مراكش - حي ...">
                </div>
                <div class="mb-3">
                    <label class="form-label">📝 ملاحظة (اختياري)</label>
                    <textarea id="custNote" class="form-control" rows="3" placeholder="أي معلومات إضافية..."></textarea>
                </div>

                <button class="btn btn-success w-100" type="button" id="whatsappOrderBtn">
                    ✅ إرسال الطلب
                </button>

                <div class="small-muted mt-2">
                    سيتم تواصلنا لتأكيد تفاصيل التوصيل.
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Sticky Cart Bar -->
    <div class="mobile-cart-bar d-md-none" id="mobileCartBar">
        <div class="d-flex align-items-center gap-2 text-white">
            <span class="fs-5">🛒</span>
            <div class="d-flex flex-column">
                <span class="small text-muted" style="font-size: 0.75rem;">المجموع</span>
                <span class="fw-bold" id="mobileCartTotal">0.00 {{ $currency }}</span>
            </div>
        </div>
        <button class="btn btn-primary rounded-pill px-4" onclick="document.getElementById('cart').scrollIntoView({behavior: 'smooth'})">
            إتمام الطلب
        </button>
    </div>

    <div id="cartToast" class="toast-banner d-none"></div>

    @php
        $productsForJs = $products->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'price' => (float) $p->price,
            ];
        });
    @endphp

    <script>
        window.GP = {
            currency: @json($currency),
            shopName: @json($shopName ?? config('goldenperfume.shop_name')),
            products: @json($productsForJs),
            orderEndpoint: @json(route('orders.store')),
            csrfToken: @json(csrf_token()),
            shippingFee: @json((float) config('goldenperfume.shipping_fee')),
            freeShippingThreshold: @json((float) config('goldenperfume.free_shipping_threshold')),
            minOrderTotal: @json((float) config('goldenperfume.min_order_total')),
        };
    </script>
@endsection

@push('scripts')
    <script src="{{ asset('js/order.js') }}"></script>
@endpush
