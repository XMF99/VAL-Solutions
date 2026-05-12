{{-- ═══════════════════════════════════════════════════════════
     Val POS — POS Design (Recipe 8b)
     Self-contained: doesn't rely on activeTemplate layout
     Renders inside whatever layout the original used
     ═══════════════════════════════════════════════════════════ --}}

@php
    use Illuminate\Support\Facades\DB;
    $vpPosUser = auth()->user();
    $vpPosStoreName = $vpPosUser->store_name ?: ($vpPosUser->business_name ?: 'متجري');
    $vpPosLogoUrl = $vpPosUser->logo_path ? asset('storage/' . $vpPosUser->logo_path) : null;
    $vpPosUserName = trim(($vpPosUser->firstname ?? '') . ' ' . ($vpPosUser->lastname ?? ''));

    $vpPosCategories = DB::table('categories')
        ->where('categories.user_id', $vpPosUser->id)
        ->where('categories.status', 1)
        ->whereNull('categories.deleted_at')
        ->leftJoin('products', function ($j) use ($vpPosUser) {
            $j->on('categories.id', '=', 'products.category_id')
              ->where('products.user_id', $vpPosUser->id)
              ->where('products.status', 1)
              ->whereNull('products.deleted_at');
        })
        ->select('categories.id', 'categories.name', 'categories.image',
                 DB::raw('COUNT(products.id) as products_count'))
        ->groupBy('categories.id', 'categories.name', 'categories.image')
        ->orderBy('categories.name')
        ->get();

    $vpPosProducts = DB::table('products')
        ->where('products.user_id', $vpPosUser->id)
        ->where('products.status', 1)
        ->whereNull('products.deleted_at')
        ->leftJoin('product_details', 'product_details.product_id', '=', 'products.id')
        ->select(
            'products.id',
            'products.name',
            'products.product_code',
            'products.category_id',
            'products.image',
            DB::raw('COALESCE(product_details.sale_price, 0) as price')
        )
        ->orderBy('products.name')
        ->get();

    $vpPosTotalProducts = $vpPosProducts->count();

    if (!function_exists('vpPosEmoji')) {
        function vpPosEmoji($categoryName, $productName) {
            $cn = mb_strtolower($categoryName ?? '');
            $pn = mb_strtolower($productName ?? '');
            if (str_contains($cn, 'ساخن') || str_contains($pn, 'إسبريسو') || str_contains($pn, 'لاتيه') ||
                str_contains($pn, 'كابتشينو') || str_contains($pn, 'موكا') || str_contains($pn, 'أمريكانو') ||
                str_contains($pn, 'ماكياتو') || str_contains($pn, 'فلات')) return '☕';
            if (str_contains($cn, 'بارد') || str_contains($pn, 'آيس') || str_contains($pn, 'فراب')) return '🧊';
            if (str_contains($cn, 'معجّن') || str_contains($cn, 'حلوي') || str_contains($pn, 'كرواسون') ||
                str_contains($pn, 'كيك') || str_contains($pn, 'دونات') || str_contains($pn, 'مافن')) return '🥐';
            if (str_contains($pn, 'شاي') || str_contains($pn, 'كرك')) return '🫖';
            if (str_contains($pn, 'مياه') || str_contains($pn, 'ماء')) return '💧';
            return '🛍️';
        }
    }
@endphp

<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>الكاشير — {{ $vpPosStoreName }}</title>
    <link rel="stylesheet" href="{{ asset('assets/ovopanel/css/main.css') }}">
</head>
<body>

<div class="vp-pos-container">

    {{-- Header --}}
    <div class="vp-pos-header">
        <div class="vp-pos-brand">
            @if($vpPosLogoUrl)
                <img src="{{ $vpPosLogoUrl }}" alt="{{ $vpPosStoreName }}" class="vp-pos-logo">
            @else
                <div class="vp-pos-logo-placeholder">🏪</div>
            @endif
            <div>
                <p class="vp-pos-store-name">{{ $vpPosStoreName }}</p>
                <p class="vp-pos-branch">الفرع الرئيسي · {{ $vpPosUserName }}</p>
            </div>
        </div>
        <div class="vp-pos-header-actions">
            <div class="vp-pos-clock">
                <span id="vpPosTime">--:--</span>
                <span class="vp-pos-date" id="vpPosDate">—</span>
            </div>
            <a href="{{ route('user.cash_register.dashboard') }}" class="vp-pos-btn-icon" title="إغلاق الكاش">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
            </a>
            <a href="{{ route('user.home') }}" class="vp-pos-btn-icon" title="الرئيسية">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
            </a>
        </div>
    </div>

    {{-- Main Layout --}}
    <div class="vp-pos-layout">

        {{-- Left: products area --}}
        <div class="vp-pos-main">

            {{-- Categories --}}
            <div class="vp-pos-categories" id="vpPosCategories">
                <button class="vp-pos-cat active" data-cat="all">
                    <div class="vp-pos-cat-icon">🛍️</div>
                    <div class="vp-pos-cat-info">
                        <span class="vp-pos-cat-name">الكل</span>
                        <span class="vp-pos-cat-count">{{ $vpPosTotalProducts }} منتج</span>
                    </div>
                </button>
                @foreach($vpPosCategories as $cat)
                    @php $catEmoji = vpPosEmoji($cat->name, ''); @endphp
                    <button class="vp-pos-cat" data-cat="{{ $cat->id }}">
                        <div class="vp-pos-cat-icon">{{ $catEmoji }}</div>
                        <div class="vp-pos-cat-info">
                            <span class="vp-pos-cat-name">{{ $cat->name }}</span>
                            <span class="vp-pos-cat-count">{{ $cat->products_count }} منتج</span>
                        </div>
                    </button>
                @endforeach
            </div>

            {{-- Search --}}
            <div class="vp-pos-search-wrap">
                <span class="vp-pos-search-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                </span>
                <input type="text" id="vpPosSearch" class="vp-pos-search"
                       placeholder="ابحث عن منتج أو امسح الباركود...">
                <span class="vp-pos-kbd">/</span>
            </div>

            {{-- Product Grid --}}
            <div class="vp-pos-grid" id="vpPosGrid">
                @forelse($vpPosProducts as $product)
                    @php
                        $catName = $vpPosCategories->firstWhere('id', $product->category_id)->name ?? '';
                        $emoji = vpPosEmoji($catName, $product->name);
                        $hasImage = !empty($product->image);
                        $imageUrl = $hasImage ? asset('assets/images/product/' . $product->image) : '';
                    @endphp
                    <button class="vp-pos-card"
                            data-id="{{ $product->id }}"
                            data-name="{{ $product->name }}"
                            data-price="{{ $product->price }}"
                            data-cat="{{ $product->category_id }}"
                            data-search="{{ mb_strtolower($product->name . ' ' . $product->product_code) }}">
                        <div class="vp-pos-card-img">
                            @if($hasImage)
                                <img src="{{ $imageUrl }}" alt="{{ $product->name }}"
                                     onerror="this.outerHTML='<div class=&quot;vp-pos-card-emoji&quot;>{{ $emoji }}</div>'">
                            @else
                                <div class="vp-pos-card-emoji">{{ $emoji }}</div>
                            @endif
                        </div>
                        <div class="vp-pos-card-body">
                            <p class="vp-pos-card-name">{{ $product->name }}</p>
                            <p class="vp-pos-card-price">
                                {{ number_format((float) $product->price, 2) }}
                                <span>ر.س</span>
                            </p>
                        </div>
                    </button>
                @empty
                    <div class="vp-pos-empty">
                        <div class="vp-pos-empty-icon">📦</div>
                        <p class="vp-pos-empty-text">لا توجد منتجات بعد. أضف منتجاتك من صفحة المنتجات.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Right: Cart Sidebar --}}
        <aside class="vp-pos-cart">
            <div class="vp-pos-cart-header">
                <h3>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"/>
                        <circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                    سلّة الطلب
                </h3>
                <span class="vp-pos-cart-counter" id="vpPosCounter">0</span>
            </div>

            <div class="vp-pos-cart-items" id="vpPosCartItems">
                <div class="vp-pos-cart-empty" id="vpPosCartEmpty">
                    <div class="vp-pos-cart-empty-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"/>
                            <circle cx="20" cy="21" r="1"/>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                        </svg>
                    </div>
                    <p>السلّة فارغة</p>
                    <span>اضغط على منتج لإضافته للسلّة</span>
                </div>
            </div>

            <div class="vp-pos-cart-summary">
                <div class="vp-pos-summary-row">
                    <span>المجموع الجزئي</span>
                    <span id="vpPosSubtotal">0.00 ر.س</span>
                </div>
                <div class="vp-pos-summary-row">
                    <span>الضريبة (15%)</span>
                    <span id="vpPosTax">0.00 ر.س</span>
                </div>
                <div class="vp-pos-summary-row vp-pos-summary-total">
                    <span>الإجمالي</span>
                    <span id="vpPosTotal">0.00 ر.س</span>
                </div>
            </div>

            <div class="vp-pos-cart-actions">
                <button class="vp-pos-btn-secondary" id="vpPosClearBtn" disabled>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                    </svg>
                    إفراغ
                </button>
                <button class="vp-pos-btn-primary" id="vpPosCheckoutBtn" disabled>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="5" width="20" height="14" rx="2"/>
                        <line x1="2" y1="10" x2="22" y2="10"/>
                    </svg>
                    إتمام البيع
                </button>
            </div>
        </aside>

    </div>

    {{-- Success Modal --}}
    <div class="vp-pos-modal" id="vpPosSuccessModal" style="display:none">
        <div class="vp-pos-modal-overlay"></div>
        <div class="vp-pos-modal-content">
            <div class="vp-pos-modal-success-icon">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
            </div>
            <h2>تمّ البيع بنجاح!</h2>
            <p>الإجمالي: <strong id="vpPosModalTotal">0.00 ر.س</strong></p>
            <p>عدد المنتجات: <strong id="vpPosModalCount">0</strong></p>
            <div class="vp-pos-modal-actions">
                <button class="vp-pos-btn-secondary" onclick="document.getElementById('vpPosSuccessModal').style.display='none'">
                    إغلاق
                </button>
                <button class="vp-pos-btn-primary" onclick="document.getElementById('vpPosSuccessModal').style.display='none'">
                    بيع جديد
                </button>
            </div>
        </div>
    </div>

</div>

<script>
(function() {
    'use strict';

    var cart = [];
    var TAX_RATE = 0.15;

    var $ = function(id) { return document.getElementById(id); };
    var searchBox  = $('vpPosSearch');
    var catBtns    = document.querySelectorAll('.vp-pos-cat');
    var cards      = document.querySelectorAll('.vp-pos-card');
    var cartItems  = $('vpPosCartItems');
    var cartEmpty  = $('vpPosCartEmpty');
    var counter    = $('vpPosCounter');
    var subtotalEl = $('vpPosSubtotal');
    var taxEl      = $('vpPosTax');
    var totalEl    = $('vpPosTotal');
    var checkoutBtn= $('vpPosCheckoutBtn');
    var clearBtn   = $('vpPosClearBtn');
    var successModal = $('vpPosSuccessModal');

    var activeCat = 'all';
    var searchTerm = '';

    function updateClock() {
        var now = new Date();
        var hh = String(now.getHours()).padStart(2, '0');
        var mm = String(now.getMinutes()).padStart(2, '0');
        $('vpPosTime').textContent = hh + ':' + mm;
        var arDate = now.toLocaleDateString('ar-SA', {
            weekday: 'short', day: 'numeric', month: 'short'
        });
        $('vpPosDate').textContent = arDate;
    }
    updateClock();
    setInterval(updateClock, 30000);

    function filterProducts() {
        cards.forEach(function(card) {
            var cardCat = card.getAttribute('data-cat');
            var cardSearch = card.getAttribute('data-search') || '';
            var matchCat = (activeCat === 'all' || cardCat === activeCat);
            var matchSearch = (!searchTerm || cardSearch.indexOf(searchTerm) !== -1);
            card.style.display = (matchCat && matchSearch) ? '' : 'none';
        });
    }

    catBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            catBtns.forEach(function(b) { b.classList.remove('active'); });
            btn.classList.add('active');
            activeCat = btn.getAttribute('data-cat');
            filterProducts();
        });
    });

    var searchTimer;
    searchBox.addEventListener('input', function(e) {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function() {
            searchTerm = e.target.value.trim().toLowerCase();
            filterProducts();
        }, 120);
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === '/' && document.activeElement.tagName !== 'INPUT'
            && document.activeElement.tagName !== 'TEXTAREA') {
            e.preventDefault();
            searchBox.focus();
            searchBox.select();
        }
    });

    cards.forEach(function(card) {
        card.addEventListener('click', function() {
            var id    = card.getAttribute('data-id');
            var name  = card.getAttribute('data-name');
            var price = parseFloat(card.getAttribute('data-price')) || 0;

            var existing = cart.find(function(it) { return it.id === id; });
            if (existing) { existing.qty++; }
            else { cart.push({ id: id, name: name, price: price, qty: 1 }); }
            renderCart();

            card.classList.remove('vp-pos-card-pulse');
            void card.offsetWidth;
            card.classList.add('vp-pos-card-pulse');
        });
    });

    function renderCart() {
        if (cart.length === 0) {
            cartEmpty.style.display = '';
            cartItems.querySelectorAll('.vp-pos-cart-item').forEach(function(el) { el.remove(); });
            counter.textContent = '0';
            checkoutBtn.disabled = true;
            clearBtn.disabled = true;
            updateTotals(0);
            return;
        }
        cartEmpty.style.display = 'none';

        var existingMap = {};
        cartItems.querySelectorAll('.vp-pos-cart-item').forEach(function(el) {
            existingMap[el.getAttribute('data-id')] = el;
        });

        cart.forEach(function(item) {
            var el = existingMap[item.id];
            if (el) {
                el.querySelector('.vp-pos-cart-item-name').textContent = item.name;
                el.querySelector('.vp-pos-cart-item-price').textContent =
                    item.price.toFixed(2) + ' × ' + item.qty + ' = ' +
                    (item.price * item.qty).toFixed(2) + ' ر.س';
                el.querySelector('.vp-pos-qty-val').textContent = item.qty;
                delete existingMap[item.id];
            } else {
                el = document.createElement('div');
                el.className = 'vp-pos-cart-item';
                el.setAttribute('data-id', item.id);
                el.innerHTML =
                    '<div class="vp-pos-cart-item-info">' +
                        '<p class="vp-pos-cart-item-name"></p>' +
                        '<p class="vp-pos-cart-item-price"></p>' +
                    '</div>' +
                    '<div class="vp-pos-cart-item-qty">' +
                        '<button data-act="inc">+</button>' +
                        '<span class="vp-pos-qty-val">1</span>' +
                        '<button data-act="dec">−</button>' +
                    '</div>' +
                    '<button class="vp-pos-cart-item-remove" data-act="rm" aria-label="حذف">' +
                        '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">' +
                            '<line x1="18" y1="6" x2="6" y2="18"/>' +
                            '<line x1="6" y1="6" x2="18" y2="18"/>' +
                        '</svg>' +
                    '</button>';
                cartItems.appendChild(el);

                el.querySelector('.vp-pos-cart-item-name').textContent = item.name;
                el.querySelector('.vp-pos-cart-item-price').textContent =
                    item.price.toFixed(2) + ' × ' + item.qty + ' = ' +
                    (item.price * item.qty).toFixed(2) + ' ر.س';
                el.querySelector('.vp-pos-qty-val').textContent = item.qty;

                el.addEventListener('click', function(e) {
                    var btn = e.target.closest('[data-act]');
                    if (!btn) return;
                    var act = btn.getAttribute('data-act');
                    var idx = cart.findIndex(function(it) { return it.id === item.id; });
                    if (idx < 0) return;
                    if (act === 'inc') cart[idx].qty++;
                    else if (act === 'dec') {
                        cart[idx].qty--;
                        if (cart[idx].qty <= 0) cart.splice(idx, 1);
                    }
                    else if (act === 'rm') cart.splice(idx, 1);
                    renderCart();
                });
            }
        });

        Object.values(existingMap).forEach(function(el) { el.remove(); });

        var totalQty = cart.reduce(function(s, it) { return s + it.qty; }, 0);
        counter.textContent = totalQty;
        checkoutBtn.disabled = false;
        clearBtn.disabled = false;

        var subtotal = cart.reduce(function(s, it) { return s + (it.price * it.qty); }, 0);
        updateTotals(subtotal);
    }

    function updateTotals(subtotal) {
        var tax = subtotal * TAX_RATE;
        var total = subtotal + tax;
        subtotalEl.textContent = subtotal.toFixed(2) + ' ر.س';
        taxEl.textContent      = tax.toFixed(2) + ' ر.س';
        totalEl.textContent    = total.toFixed(2) + ' ر.س';
    }

    clearBtn.addEventListener('click', function() {
        if (cart.length === 0) return;
        if (confirm('هل أنت متأكّد من إفراغ السلّة؟')) {
            cart = [];
            renderCart();
        }
    });

    checkoutBtn.addEventListener('click', function() {
        if (cart.length === 0) return;
        var subtotal = cart.reduce(function(s, it) { return s + (it.price * it.qty); }, 0);
        var total = subtotal * (1 + TAX_RATE);
        var totalQty = cart.reduce(function(s, it) { return s + it.qty; }, 0);

        $('vpPosModalTotal').textContent = total.toFixed(2) + ' ر.س';
        $('vpPosModalCount').textContent = totalQty;
        successModal.style.display = 'flex';

        setTimeout(function() {
            cart = [];
            renderCart();
        }, 300);
    });

    successModal.addEventListener('click', function(e) {
        if (e.target.classList.contains('vp-pos-modal-overlay')) {
            successModal.style.display = 'none';
        }
    });

    renderCart();
})();
</script>

</body>
</html>
