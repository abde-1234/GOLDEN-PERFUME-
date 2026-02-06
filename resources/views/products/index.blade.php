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
                    <table class="table align-middle">
                        <thead class="bg-light small text-muted text-uppercase">
                            <tr>
                                <th class="border-0 py-3 ps-4" style="font-weight: 600;">المنتج</th>
                                <th class="border-0 py-3 text-center" style="font-weight: 600;">الكمية</th>
                                <th class="border-0 py-3 text-end" style="font-weight: 600;">المجموع</th>
                                <th class="border-0 py-3 text-end pe-4" style="width: 50px;"></th>
                            </tr>
                        </thead>
                        <tbody id="cartBody" class="border-top-0">
                            <tr><td colspan="4" class="text-center py-5 text-muted">السلة فارغة. ابدأ التسوق الآن!</td></tr>
                        </tbody>
                        <tfoot class="border-top">
                            <tr>
                                <td colspan="2" class="text-end pt-4">
                                    <span class="text-muted small">الإجمالي الكلي</span>
                                </td>
                                <td class="text-end pt-4">
                                    <span class="fw-bold fs-4 text-dark"><span id="cartTotal">0.00</span> <span class="fs-6 text-muted">{{ $currency }}</span></span>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mt-3 px-2">
                    <button class="btn btn-link text-danger text-decoration-none btn-sm px-0" type="button" id="clearCartBtn">
                        <i class="bi bi-trash me-1"></i> إفراغ السلة
                    </button>
                    <div class="text-success small fw-bold">
                        <i class="bi bi-check-circle-fill me-1"></i> توصيل مجاني
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4 sticky-top rounded-4" style="top: 20px; z-index: 100;">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <span class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px;">1</span>
                    <h2 class="h5 fw-bold mb-0">معلومات التوصيل</h2>
                </div>

                <div class="form-floating mb-3">
                    <input id="custName" class="form-control rounded-3" placeholder="الاسم الكامل">
                    <label for="custName" class="text-muted">الاسم الكامل</label>
                </div>

                <div class="form-floating mb-3">
                    <input id="custPhone" class="form-control rounded-3" placeholder="رقم الهاتف">
                    <label for="custPhone" class="text-muted">رقم الهاتف</label>
                </div>

                <div class="form-floating mb-3">
                    <input id="custAddress" class="form-control rounded-3" placeholder="العنوان">
                    <label for="custAddress" class="text-muted">العنوان / المدينة</label>
                </div>

                <div class="form-floating mb-4">
                    <textarea id="custNote" class="form-control rounded-3" placeholder="ملاحظات" style="height: 100px"></textarea>
                    <label for="custNote" class="text-muted">ملاحظات إضافية (اختياري)</label>
                </div>

                <button class="btn btn-dark w-100 py-3 rounded-pill fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2" type="button" id="whatsappOrderBtn">
                    <span>تأكيد الطلب</span>
                    <i class="bi bi-arrow-left"></i>
                </button>

                <div class="text-center mt-3">
                    <small class="text-muted">الدفع عند الاستلام 💵</small>
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
                'image_url' => $p->image_path ? asset($p->image_path) : asset('images/logo.png'),
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
