(function () {
  if (!window.GP) return;

  const PRODUCTS = new Map((window.GP.products || []).map(p => [String(p.id), p]));
  const CART_KEY = 'gp_cart_v1';

  function loadCart() {
    try {
      const raw = localStorage.getItem(CART_KEY);
      if (!raw) return {};
      const obj = JSON.parse(raw);
      return (obj && typeof obj === 'object') ? obj : {};
    } catch (e) {
      return {};
    }
  }

  function saveCart(cart) {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
  }

  function formatMoney(n) {
    const x = Math.round((Number(n) || 0) * 100) / 100;
    return x.toFixed(2);
  }

  const cartBody = document.getElementById('cartBody');
  const cartTotal = document.getElementById('cartTotal');
  const mobileCartBar = document.getElementById('mobileCartBar');
  const mobileCartTotal = document.getElementById('mobileCartTotal');
  const orderBtn = document.getElementById('whatsappOrderBtn');
  const clearCartBtn = document.getElementById('clearCartBtn');
  const promoInput = document.getElementById('promoCodeInput');
  const applyPromoBtn = document.getElementById('applyPromoBtn');
  const toastBanner = document.getElementById('cartToast');

  const custName = document.getElementById('custName');
  const custPhone = document.getElementById('custPhone');
  const custAddress = document.getElementById('custAddress');
  const custNote = document.getElementById('custNote');

  let cart = loadCart();
  const PROMO_KEY = 'gp_promo_v1';
  let promoCode = (localStorage.getItem(PROMO_KEY) || '').trim();

  function computeDiscount(code, total) {
    code = String(code || '').toUpperCase().trim();
    if (!code) return 0;
    if (code === 'GP10') return Math.round(total * 0.10 * 100) / 100;
    if (code === 'GP5') return Math.round(total * 0.05 * 100) / 100;
    if (code === 'WELCOME10') return Math.min(total, 10);
    return 0;
  }

  function cartItems() {
    return Object.entries(cart)
      .filter(([id, qty]) => PRODUCTS.has(String(id)) && Number(qty) > 0)
      .map(([id, qty]) => ({
        id: String(id),
        qty: Math.max(1, Number(qty) || 1),
        product: PRODUCTS.get(String(id)),
      }));
  }

  function calcTotal(items) {
    return items.reduce((sum, it) => sum + (it.product.price * it.qty), 0);
  }

  function buildOrderPayload(items) {
    const name = (custName?.value || '').trim();
    const phone = (custPhone?.value || '').trim();
    const address = (custAddress?.value || '').trim();
    const note = (custNote?.value || '').trim();

    return {
      customer_name: name,
      customer_phone: phone,
      customer_address: address,
      customer_note: note,
      promo_code: promoCode,
      items: items.map((it) => ({
        product_id: Number(it.id),
        qty: it.qty,
      })),
    };
  }

  function renderCart() {
    const items = cartItems();
    const total = calcTotal(items);
    const discount = computeDiscount(promoCode, total);
    const grandTotal = Math.max(0, Math.round((total - discount) * 100) / 100);
    var shippingFeeCfg = Number(window.GP?.shippingFee || 0);
    var freeThreshold = Number(window.GP?.freeShippingThreshold || 0);
    var minOrder = Number(window.GP?.minOrderTotal || 0);
    var shipping = grandTotal >= freeThreshold ? 0 : shippingFeeCfg;
    var totalWithShipping = Math.round((grandTotal + shipping) * 100) / 100;

    if (!items.length) {
      cartBody.innerHTML = '<tr><td colspan="4" class="text-muted">السلة فارغة.</td></tr>';
    } else {
      cartBody.innerHTML = items.map((it) => {
        const sub = it.product.price * it.qty;
        return `
          <tr data-cart-row="${it.id}">
            <td>
              <div class="fw-bold">${escapeHtml(it.product.name)}</div>
              <div class="small text-muted">${formatMoney(it.product.price)} ${window.GP.currency}</div>
            </td>
            <td>
              <input class="form-control form-control-sm" type="number" min="1" step="1" value="${it.qty}" data-qty-input="${it.id}">
            </td>
            <td class="fw-bold">${formatMoney(sub)} ${window.GP.currency}</td>
            <td>
              <button class="btn btn-sm btn-outline-danger" type="button" data-remove="${it.id}">×</button>
            </td>
          </tr>
        `;
      }).join('');
    }

    cartTotal.textContent = formatMoney(total);
    var headerTotalEl = document.getElementById('cartTotalHeader');
    if (headerTotalEl) {
      headerTotalEl.textContent = formatMoney(total);
    }
    var cartDiscountEl = document.getElementById('cartDiscount');
    var cartGrandTotalEl = document.getElementById('cartGrandTotal');
    var cartShippingEl = document.getElementById('cartShipping');
    if (cartDiscountEl) cartDiscountEl.textContent = formatMoney(discount);
    if (cartGrandTotalEl) cartGrandTotalEl.textContent = formatMoney(grandTotal);
    if (cartShippingEl) cartShippingEl.textContent = formatMoney(shipping);

    // Update mobile cart bar
    if (mobileCartBar && mobileCartTotal) {
      mobileCartTotal.textContent = formatMoney(totalWithShipping) + ' ' + window.GP.currency;
      if (items.length > 0) {
        mobileCartBar.classList.add('visible');
      } else {
        mobileCartBar.classList.remove('visible');
      }
    }

    var navBadge = document.getElementById('navCartCount');
    if (navBadge) {
      var count = items.reduce((s, it) => s + it.qty, 0);
      navBadge.textContent = String(count);
      navBadge.classList.toggle('d-none', count <= 0);
    }
  }

  function escapeHtml(str) {
    return String(str)
      .replaceAll('&', '&amp;')
      .replaceAll('<', '&lt;')
      .replaceAll('>', '&gt;')
      .replaceAll('"', '&quot;')
      .replaceAll("'", '&#039;');
  }

  // Add to cart buttons
  document.querySelectorAll('[data-add-to-cart]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const id = String(btn.getAttribute('data-add-to-cart'));
      if (!PRODUCTS.has(id)) return;

      cart[id] = (Number(cart[id]) || 0) + 1;
      saveCart(cart);
      renderCart();

      btn.textContent = 'تم ✅';
      setTimeout(() => (btn.textContent = 'أضف للسلة'), 800);
        showToast('تمت إضافة المنتج إلى السلة ✅');
    });
  });

  // Qty / remove (event delegation)
  cartBody.addEventListener('input', (e) => {
    const t = e.target;
    if (!(t instanceof HTMLElement)) return;
    const id = t.getAttribute('data-qty-input');
    if (!id) return;

    const val = Math.max(1, Number((t).value || 1));
    cart[String(id)] = val;
    saveCart(cart);
    renderCart();
  });

  cartBody.addEventListener('click', (e) => {
    const t = e.target;
    if (!(t instanceof HTMLElement)) return;
    const id = t.getAttribute('data-remove');
    if (!id) return;

    delete cart[String(id)];
    saveCart(cart);
    renderCart();
  });

  clearCartBtn?.addEventListener('click', () => {
    cart = {};
    saveCart(cart);
    renderCart();
  });

  applyPromoBtn?.addEventListener('click', () => {
    promoCode = (promoInput?.value || '').trim();
    localStorage.setItem(PROMO_KEY, promoCode);
    renderCart();
  });
  promoInput?.addEventListener('input', () => {
    promoCode = (promoInput?.value || '').trim();
    localStorage.setItem(PROMO_KEY, promoCode);
    renderCart();
  });
  if (promoInput) {
    promoInput.value = promoCode;
  }

  // Update whatsapp link when customer data changes
  [custName, custPhone, custAddress, custNote].forEach((el) => {
    if (!el) return;
    el.addEventListener('input', () => renderCart());
  });

  orderBtn?.addEventListener('click', async (e) => {
    e.preventDefault();
    const items = cartItems();
    if (!items.length) {
      alert('السلة فارغة. أضف منتجاً واحداً على الأقل.');
      return;
    }

    const payload = buildOrderPayload(items);

    if (!payload.customer_name || !payload.customer_phone || !payload.customer_address) {
      alert('الاسم والهاتف والعنوان مطلوبة لإرسال الطلب.');
      return;
    }
    // Minimum order validation (before shipping)
    var minOrder = Number(window.GP?.minOrderTotal || 0);
    var total = calcTotal(items);
    var discount = computeDiscount(promoCode, total);
    var grand = Math.max(0, Math.round((total - discount) * 100) / 100);
    if (minOrder && grand < minOrder) {
      alert('الحد الأدنى للطلب هو ' + formatMoney(minOrder) + ' ' + window.GP.currency + '.');
      return;
    }

    if (!window.GP.orderEndpoint || !window.GP.csrfToken) {
      alert('إعدادات الطلب غير مكتملة.');
      return;
    }

    orderBtn.disabled = true;
    const originalText = orderBtn.textContent;
    orderBtn.textContent = 'جاري إرسال الطلب...';

    try {
      const res = await fetch(window.GP.orderEndpoint, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': window.GP.csrfToken,
        },
        body: JSON.stringify(payload),
      });

      if (!res.ok) {
        throw new Error('Request failed');
      }

      const data = await res.json();
      alert('تم إرسال طلبك بنجاح! رقم الطلب: ' + (data.order_id ?? 'غير محدد'));

      cart = {};
      saveCart(cart);
      renderCart();
    } catch (err) {
      alert('حدث خطأ أثناء إرسال الطلب. حاول مرة أخرى بعد قليل.');
    } finally {
      orderBtn.disabled = false;
      orderBtn.textContent = originalText;
    }
  });

  // Filters
  function applyFilter(filter) {
    document.querySelectorAll('[data-filter]').forEach((b) => {
      b.classList.toggle('btn-dark', b.getAttribute('data-filter') === filter);
      b.classList.toggle('btn-outline-dark', b.getAttribute('data-filter') !== filter);
    });

    document.querySelectorAll('.product-card').forEach((card) => {
      const cat = card.getAttribute('data-category');
      const show = (filter === 'all') || (cat === filter);
      card.classList.toggle('d-none', !show);
    });
  }

  document.querySelectorAll('[data-filter]').forEach((btn) => {
    btn.addEventListener('click', () => applyFilter(btn.getAttribute('data-filter')));
  });

  applyFilter('all');
  renderCart();

  function showToast(msg) {
    if (!toastBanner) return;
    toastBanner.textContent = String(msg || '');
    toastBanner.classList.remove('d-none');
    toastBanner.classList.add('show');
    setTimeout(() => {
      toastBanner.classList.remove('show');
      toastBanner.classList.add('d-none');
    }, 1800);
  }
})();
