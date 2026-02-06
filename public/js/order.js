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
  const toastBanner = document.getElementById('cartToast');
  const cartTotalHeader = document.getElementById('cartTotalHeader');

  const custName = document.getElementById('custName');
  const custPhone = document.getElementById('custPhone');
  const custAddress = document.getElementById('custAddress');
  const custNote = document.getElementById('custNote');

  let cart = loadCart();

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
      promo_code: '',
      items: items.map((it) => ({
        product_id: Number(it.id),
        qty: it.qty,
      })),
    };
  }

  function renderCart() {
    const items = cartItems();
    const total = calcTotal(items);
    
    // No discount, No shipping
    const grandTotal = total;

    if (!items.length) {
      cartBody.innerHTML = '<tr><td colspan="4" class="text-muted">السلة فارغة.</td></tr>';
      cartTotal.innerText = '0.00';
      if (cartTotalHeader) cartTotalHeader.innerText = '0.00';
      if(mobileCartBar) mobileCartBar.classList.add('d-none');
      if(orderBtn) orderBtn.disabled = true;
      if(clearCartBtn) clearCartBtn.disabled = true;
      return;
    }

    let html = '';
    items.forEach((it) => {
      const lineTotal = it.product.price * it.qty;
      html += `
        <tr>
          <td>
            <div class="d-flex align-items-center gap-2">
              <img src="${it.product.image_url}" class="rounded border" width="40" height="40" style="object-fit:cover">
              <div class="text-truncate" style="max-width:120px;" title="${it.product.name}">${it.product.name}</div>
            </div>
          </td>
          <td class="text-center">
            <div class="input-group input-group-sm flex-nowrap" style="width: 80px; margin: 0 auto;">
              <button class="btn btn-outline-secondary px-1" onclick="window.GP.updateQty('${it.id}', -1)">-</button>
              <input type="text" class="form-control text-center px-0" value="${it.qty}" readonly>
              <button class="btn btn-outline-secondary px-1" onclick="window.GP.updateQty('${it.id}', 1)">+</button>
            </div>
          </td>
          <td class="text-end text-nowrap">${formatMoney(lineTotal)}</td>
          <td class="text-center">
            <button class="btn btn-link text-danger p-0" onclick="window.GP.removeItem('${it.id}')">
              &times;
            </button>
          </td>
        </tr>
      `;
    });

    cartBody.innerHTML = html;
    cartTotal.innerText = formatMoney(total);
    if (cartTotalHeader) cartTotalHeader.innerText = formatMoney(total);
    
    // Update mobile bar
    if(mobileCartBar) mobileCartBar.classList.remove('d-none');
    if(mobileCartTotal) mobileCartTotal.innerText = formatMoney(total);
    
    if(orderBtn) orderBtn.disabled = false;
    if(clearCartBtn) clearCartBtn.disabled = false;
  }

  window.GP.updateQty = function(id, delta) {
    const cur = Number(cart[String(id)]) || 1;
    const next = Math.max(1, cur + (Number(delta) || 0));
    cart[String(id)] = next;
    saveCart(cart);
    renderCart();
  };

  window.GP.removeItem = function(id) {
    delete cart[String(id)];
    saveCart(cart);
    renderCart();
    showToast('تمت إزالة المنتج من السلة ❌');
  };

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

  // Clean up any stale promo-related state (removed feature)
  try {
    localStorage.removeItem('gp_promo_v1');
  } catch (_) {}

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
    var grand = Math.max(0, Math.round(total * 100) / 100);
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
