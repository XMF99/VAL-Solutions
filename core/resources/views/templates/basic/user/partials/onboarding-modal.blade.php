{{-- ════════════════════════════════════════════════════════════════════
   Val POS - Onboarding Modal (Recipe 3)
   يُضمَّن في user/dashboard.blade.php وغيرها
   يظهر تلقائياً إذا onboarding_completed = false
   ════════════════════════════════════════════════════════════════════ --}}

@if(auth()->check() && empty(auth()->user()->onboarding_completed))

@php
    $vpOnbUser = auth()->user();
    $vpOnbDefaultName = $vpOnbUser->business_name
        ?: trim(($vpOnbUser->firstname ?? '') . ' ' . ($vpOnbUser->lastname ?? ''));
    $vpOnbStoreName = $vpOnbUser->store_name ?? '';
    $vpOnbLat       = $vpOnbUser->business_lat !== null ? (float) $vpOnbUser->business_lat : null;
    $vpOnbLng       = $vpOnbUser->business_lng !== null ? (float) $vpOnbUser->business_lng : null;
    $vpOnbType      = $vpOnbUser->business_type ?? '';
    $vpOnbCr        = $vpOnbUser->cr_number ?? '';
    $vpOnbAddr      = $vpOnbUser->business_address ?? '';
    $vpOnbLogoPath  = $vpOnbUser->logo_path ?? null;
    $vpOnbLogoUrl   = $vpOnbLogoPath ? asset('storage/' . $vpOnbLogoPath) : '';
@endphp

{{-- Leaflet CSS & JS (مرة واحدة) --}}
@push('style')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
      crossorigin="anonymous">
@endpush

<div class="vp-onb-overlay open" id="vpOnbOverlay" role="dialog" aria-modal="true" aria-labelledby="vpOnbTitle">
    <div class="vp-onb-modal">

        {{-- ━━━━━━━━━━━━━━━ HEADER ━━━━━━━━━━━━━━━ --}}
        <div class="vp-onb-header">
            <div class="vp-onb-header-top">
                <div class="vp-onb-header-icon">🏪</div>
                <div class="vp-onb-header-text">
                    <h2 class="vp-onb-header-title" id="vpOnbTitle">أكمل بيانات نشاطك التجاري</h2>
                    <p class="vp-onb-header-subtitle">خطوة واحدة فقط للانطلاق مع Val POS — يستغرق أقل من دقيقة</p>
                </div>
            </div>

            {{-- Step indicator --}}
            <div class="vp-onb-steps">
                <div class="vp-onb-step active" data-step="1">
                    <div class="vp-onb-step-num"><span class="vp-onb-step-num-text">1</span></div>
                    <span class="vp-onb-step-label">معلومات النشاط</span>
                </div>
                <div class="vp-onb-step-divider"></div>
                <div class="vp-onb-step" data-step="2">
                    <div class="vp-onb-step-num"><span class="vp-onb-step-num-text">2</span></div>
                    <span class="vp-onb-step-label">الموقع</span>
                </div>
                <div class="vp-onb-step-divider"></div>
                <div class="vp-onb-step" data-step="3">
                    <div class="vp-onb-step-num"><span class="vp-onb-step-num-text">3</span></div>
                    <span class="vp-onb-step-label">المراجعة</span>
                </div>
            </div>
        </div>

        {{-- ━━━━━━━━━━━━━━━ BODY ━━━━━━━━━━━━━━━ --}}
        <div class="vp-onb-body">

            {{-- ─── STEP 1: Business Info ─── --}}
            <div class="vp-onb-step-content active" data-step-content="1">
                <h3 class="vp-onb-step-heading">عرّفنا على نشاطك</h3>
                <p class="vp-onb-step-desc">ساعدنا في تهيئة Val POS ليناسب طبيعة عملك. كل المعلومات تبقى خاصة بحسابك.</p>

                {{-- Logo Upload Section --}}
                <div class="vp-onb-field vp-onb-logo-field">
                    <label class="vp-onb-field-label">
                        شعار المحل
                        <span class="vp-onb-field-hint">اختياري — يظهر على الفواتير والإيصالات</span>
                    </label>
                    <div class="vp-onb-logo-uploader">
                        <div class="vp-onb-logo-preview" id="vpOnbLogoPreview">
                            @if($vpOnbLogoUrl)
                                <img src="{{ $vpOnbLogoUrl }}" alt="شعار المحل" id="vpOnbLogoImg">
                            @else
                                <div class="vp-onb-logo-placeholder" id="vpOnbLogoPlaceholder">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path d="M21 19V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2z"/>
                                        <circle cx="8.5" cy="8.5" r="1.5"/>
                                        <path d="M21 15l-5-5L5 21"/>
                                    </svg>
                                </div>
                                <img src="" alt="شعار المحل" id="vpOnbLogoImg" style="display:none">
                            @endif
                        </div>
                        <div class="vp-onb-logo-actions">
                            <input type="file" id="vpOnbLogoInput" accept="image/png,image/jpeg,image/jpg,image/webp,image/svg+xml" hidden>
                            <button type="button" class="vp-onb-btn-upload" id="vpOnbLogoBtn">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
                                    <polyline points="17 8 12 3 7 8"/>
                                    <line x1="12" y1="3" x2="12" y2="15"/>
                                </svg>
                                <span id="vpOnbLogoBtnText">{{ $vpOnbLogoUrl ? 'تغيير الشعار' : 'اختر صورة الشعار' }}</span>
                            </button>
                            <button type="button" class="vp-onb-btn-remove-logo" id="vpOnbLogoRemoveBtn" style="display:{{ $vpOnbLogoUrl ? 'inline-flex' : 'none' }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="18" y1="6" x2="6" y2="18"/>
                                    <line x1="6" y1="6" x2="18" y2="18"/>
                                </svg>
                                إزالة
                            </button>
                            <p class="vp-onb-logo-hint">PNG، JPG، SVG، WebP — حتّى 2 ميجابايت</p>
                        </div>
                    </div>
                    <div class="vp-onb-field-error" id="vpOnbLogoError">حجم/نوع الصورة غير مدعوم</div>
                </div>

                <div class="vp-onb-field">
                    <label class="vp-onb-field-label">
                        اسم النشاط التجاري (الاسم القانوني)
                        <span class="vp-required">*</span>
                        <span class="vp-onb-field-hint">كما يظهر في السجل التجاري</span>
                    </label>
                    <input type="text"
                           class="vp-onb-input"
                           id="vpOnbBusinessName"
                           placeholder="مثال: مؤسسة بيت الحبق التجارية"
                           value="{{ $vpOnbDefaultName }}"
                           maxlength="120">
                    <div class="vp-onb-field-error">يرجى إدخال اسم النشاط (حد أدنى 2 أحرف)</div>
                </div>

                <div class="vp-onb-field">
                    <label class="vp-onb-field-label">
                        اسم المحل (يظهر على الفاتورة)
                        <span class="vp-required">*</span>
                        <span class="vp-onb-field-hint">الاسم التجاري المختصر الذي يراه الزبائن</span>
                    </label>
                    <input type="text"
                           class="vp-onb-input"
                           id="vpOnbStoreName"
                           placeholder="مثال: مطعم بيت الحبق، كافيه الشام..."
                           value="{{ $vpOnbStoreName }}"
                           maxlength="120">
                    <div class="vp-onb-field-error">يرجى إدخال اسم المحل (حد أدنى 2 أحرف)</div>
                </div>

                <div class="vp-onb-field">
                    <label class="vp-onb-field-label">
                        نوع النشاط
                        <span class="vp-required">*</span>
                        <span class="vp-onb-field-hint">اختر الأقرب لطبيعة عملك</span>
                    </label>

                    <div class="vp-onb-types" id="vpOnbTypes">
                        @php
                            $businessTypes = [
                                ['key' => 'restaurant',  'emoji' => '🍴', 'name' => 'مطعم'],
                                ['key' => 'cafe',        'emoji' => '☕', 'name' => 'كافيه'],
                                ['key' => 'bakery',      'emoji' => '🥐', 'name' => 'مخبز / حلويات'],
                                ['key' => 'grocery',     'emoji' => '🛒', 'name' => 'بقالة / سوبرماركت'],
                                ['key' => 'retail',      'emoji' => '🛍️', 'name' => 'تجزئة عام'],
                                ['key' => 'fashion',     'emoji' => '👗', 'name' => 'ملابس / موضة'],
                                ['key' => 'electronics', 'emoji' => '📱', 'name' => 'إلكترونيات'],
                                ['key' => 'pharmacy',    'emoji' => '💊', 'name' => 'صيدلية'],
                                ['key' => 'beauty',      'emoji' => '💅', 'name' => 'تجميل / صالون'],
                                ['key' => 'auto',        'emoji' => '🚗', 'name' => 'سيارات / قطع غيار'],
                                ['key' => 'services',    'emoji' => '🔧', 'name' => 'خدمات'],
                                ['key' => 'other',       'emoji' => '🏬', 'name' => 'أخرى'],
                            ];
                        @endphp

                        @foreach($businessTypes as $type)
                            <label class="vp-onb-type {{ $vpOnbType === $type['key'] ? 'selected' : '' }}"
                                   data-type="{{ $type['key'] }}">
                                <input type="radio"
                                       name="business_type"
                                       value="{{ $type['key'] }}"
                                       {{ $vpOnbType === $type['key'] ? 'checked' : '' }}>
                                <span class="vp-onb-type-emoji">{{ $type['emoji'] }}</span>
                                <span class="vp-onb-type-name">{{ $type['name'] }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div class="vp-onb-field-error" id="vpOnbTypeError">يرجى اختيار نوع نشاطك</div>
                </div>

                <div class="vp-onb-field">
                    <label class="vp-onb-field-label">
                        رقم السجل التجاري
                        <span class="vp-onb-field-hint">اختياري — يمكنك إضافته لاحقاً</span>
                    </label>
                    <input type="text"
                           class="vp-onb-input"
                           id="vpOnbCrNumber"
                           placeholder="1010xxxxxx"
                           value="{{ $vpOnbCr }}"
                           inputmode="numeric"
                           maxlength="20">
                </div>
            </div>

            {{-- ─── STEP 2: Map / Location ─── --}}
            <div class="vp-onb-step-content" data-step-content="2">
                <h3 class="vp-onb-step-heading">حدد موقع نشاطك على الخريطة</h3>
                <p class="vp-onb-step-desc">اسحب الدبوس إلى موقع المتجر بدقة. سنستخدم الموقع لتقارير المبيعات وخدمة التوصيل لاحقاً.</p>

                <div class="vp-onb-map-controls">
                    <button type="button" class="vp-onb-map-btn" id="vpOnbLocateBtn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <circle cx="12" cy="12" r="3"/>
                            <path d="M12 1v3M12 20v3M1 12h3M20 12h3M5.6 5.6l2.1 2.1M16.3 16.3l2.1 2.1M5.6 18.4l2.1-2.1M16.3 7.7l2.1-2.1"/>
                        </svg>
                        استخدم موقعي الحالي
                    </button>

                    <div class="vp-onb-map-coords" style="flex: 1;">
                        <div class="vp-onb-map-coords-item">
                            <span>خط العرض:</span>
                            <strong id="vpOnbLat">—</strong>
                        </div>
                        <div class="vp-onb-map-coords-item">
                            <span>خط الطول:</span>
                            <strong id="vpOnbLng">—</strong>
                        </div>
                    </div>
                </div>

                <div class="vp-onb-map-wrap">
                    <div id="vpOnbMap"></div>
                    <div class="vp-onb-map-loading hidden" id="vpOnbMapLoading">
                        <span class="vp-onb-spinner"></span>
                        <span>جارٍ تحديد موقعك...</span>
                    </div>
                </div>

                <div class="vp-onb-field">
                    <label class="vp-onb-field-label">
                        العنوان النصّي
                        <span class="vp-required">*</span>
                        <span class="vp-onb-field-hint">يُعبَّأ تلقائياً من الخريطة، ويمكنك تعديله</span>
                    </label>
                    <textarea class="vp-onb-textarea"
                              id="vpOnbAddress"
                              rows="2"
                              placeholder="مثال: حيّ الزهراء، شارع الأمير سلطان، جدّة">{{ $vpOnbAddr }}</textarea>
                    <div class="vp-onb-field-error">يرجى إدخال العنوان</div>
                </div>
            </div>

            {{-- ─── STEP 3: Review ─── --}}
            <div class="vp-onb-step-content" data-step-content="3">
                <h3 class="vp-onb-step-heading">راجع بياناتك قبل الحفظ</h3>
                <p class="vp-onb-step-desc">تأكد من المعلومات أدناه. يمكنك تعديل أيّ بند بالضغط على "تعديل".</p>

                <div class="vp-onb-review">
                    {{-- Logo preview at top of review --}}
                    <div class="vp-onb-review-item vp-onb-review-logo-item" id="vpOnbReviewLogoItem" style="display:none">
                        <div class="vp-onb-review-logo-thumb" id="vpOnbReviewLogoThumb">
                            <img src="" alt="شعار" id="vpOnbReviewLogoImg">
                        </div>
                        <div class="vp-onb-review-content">
                            <div class="vp-onb-review-label">شعار المحل</div>
                            <div class="vp-onb-review-value" id="vpOnbReviewLogoText">تم تحميل الشعار ✓</div>
                        </div>
                        <button type="button" class="vp-onb-review-edit" data-goto="1">تغيير</button>
                    </div>

                    <div class="vp-onb-review-item">
                        <div class="vp-onb-review-icon">🏪</div>
                        <div class="vp-onb-review-content">
                            <div class="vp-onb-review-label">اسم النشاط (القانوني)</div>
                            <div class="vp-onb-review-value" id="vpOnbReviewName">—</div>
                        </div>
                        <button type="button" class="vp-onb-review-edit" data-goto="1">تعديل</button>
                    </div>

                    <div class="vp-onb-review-item">
                        <div class="vp-onb-review-icon">🧾</div>
                        <div class="vp-onb-review-content">
                            <div class="vp-onb-review-label">اسم المحل (يظهر على الفاتورة)</div>
                            <div class="vp-onb-review-value" id="vpOnbReviewStore">—</div>
                        </div>
                        <button type="button" class="vp-onb-review-edit" data-goto="1">تعديل</button>
                    </div>

                    <div class="vp-onb-review-item">
                        <div class="vp-onb-review-icon">🏷️</div>
                        <div class="vp-onb-review-content">
                            <div class="vp-onb-review-label">نوع النشاط</div>
                            <div class="vp-onb-review-value" id="vpOnbReviewType">—</div>
                        </div>
                        <button type="button" class="vp-onb-review-edit" data-goto="1">تعديل</button>
                    </div>

                    <div class="vp-onb-review-item">
                        <div class="vp-onb-review-icon">📋</div>
                        <div class="vp-onb-review-content">
                            <div class="vp-onb-review-label">السجل التجاري</div>
                            <div class="vp-onb-review-value" id="vpOnbReviewCr">—</div>
                        </div>
                        <button type="button" class="vp-onb-review-edit" data-goto="1">تعديل</button>
                    </div>

                    <div class="vp-onb-review-item">
                        <div class="vp-onb-review-icon">📍</div>
                        <div class="vp-onb-review-content">
                            <div class="vp-onb-review-label">الموقع والعنوان</div>
                            <div class="vp-onb-review-value" id="vpOnbReviewAddress">—</div>
                        </div>
                        <button type="button" class="vp-onb-review-edit" data-goto="2">تعديل</button>
                    </div>
                </div>

                <div class="vp-onb-confirm-note">
                    <span class="vp-onb-confirm-note-icon">✓</span>
                    <span>بحفظ هذه البيانات، ستظهر لك لوحة التحكم كاملة وستتمكن من إضافة المنتجات والبدء بالبيع فوراً.</span>
                </div>
            </div>

            {{-- ─── SUCCESS STATE ─── --}}
            <div class="vp-onb-step-content" data-step-content="success">
                <div class="vp-onb-success">
                    <div class="vp-onb-success-icon">✓</div>
                    <h3 class="vp-onb-success-title">تم الحفظ بنجاح!</h3>
                    <p class="vp-onb-success-text">
                        أهلاً بك في Val POS. لوحتك جاهزة الآن للانطلاق.<br>
                        جارٍ تحويلك إلى لوحة التحكم...
                    </p>
                </div>
            </div>

        </div>

        {{-- ━━━━━━━━━━━━━━━ FOOTER ━━━━━━━━━━━━━━━ --}}
        <div class="vp-onb-footer" id="vpOnbFooter">
            <button type="button" class="vp-onb-btn vp-onb-btn-secondary" id="vpOnbBackBtn" style="display: none;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M9 18l6-6-6-6"/>
                </svg>
                السابق
            </button>

            <div class="vp-onb-progress">
                <span id="vpOnbProgressText">الخطوة 1 من 3</span>
                <div class="vp-onb-progress-bar">
                    <div class="vp-onb-progress-fill" id="vpOnbProgressFill" style="width: 33%;"></div>
                </div>
            </div>

            <button type="button" class="vp-onb-btn vp-onb-btn-primary" id="vpOnbNextBtn">
                التالي
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
            </button>

            <button type="button" class="vp-onb-btn vp-onb-btn-success" id="vpOnbSubmitBtn" style="display: none;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M20 6L9 17l-5-5"/>
                </svg>
                <span id="vpOnbSubmitText">إتمام وحفظ البيانات</span>
            </button>
        </div>

    </div>
</div>

@push('script')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin="anonymous"></script>
<script>
(function() {
    'use strict';

    /* ───── Configuration ───── */
    var CSRF = '{{ csrf_token() }}';
    var SAVE_URL = '{{ route('user.onboarding.complete') }}';
    var DEFAULT_LAT = 24.7136;  // وسط السعودية تقريباً
    var DEFAULT_LNG = 46.6753;
    var DEFAULT_ZOOM = 6;
    var LOCATED_ZOOM = 16;

    /* ───── State ───── */
    var currentStep = 1;
    var totalSteps = 3;
    var map = null;
    var marker = null;
    var selectedLat = {{ $vpOnbLat !== null ? $vpOnbLat : 'null' }};
    var selectedLng = {{ $vpOnbLng !== null ? $vpOnbLng : 'null' }};
    var selectedType = @json($vpOnbType);
    var typeNames = {
        'restaurant': 'مطعم',
        'cafe': 'كافيه',
        'bakery': 'مخبز / حلويات',
        'grocery': 'بقالة / سوبرماركت',
        'retail': 'تجزئة عام',
        'fashion': 'ملابس / موضة',
        'electronics': 'إلكترونيات',
        'pharmacy': 'صيدلية',
        'beauty': 'تجميل / صالون',
        'auto': 'سيارات / قطع غيار',
        'services': 'خدمات',
        'other': 'أخرى'
    };

    /* ───── DOM References ───── */
    var $ = function(id) { return document.getElementById(id); };
    var overlay   = $('vpOnbOverlay');
    var nextBtn   = $('vpOnbNextBtn');
    var backBtn   = $('vpOnbBackBtn');
    var submitBtn = $('vpOnbSubmitBtn');
    var nameField = $('vpOnbBusinessName');
    var storeField = $('vpOnbStoreName');
    var crField   = $('vpOnbCrNumber');
    var addrField = $('vpOnbAddress');
    var latLabel  = $('vpOnbLat');
    var lngLabel  = $('vpOnbLng');
    var loading   = $('vpOnbMapLoading');

    /* ───── Logo Upload State ───── */
    var logoInput       = $('vpOnbLogoInput');
    var logoBtn         = $('vpOnbLogoBtn');
    var logoBtnText     = $('vpOnbLogoBtnText');
    var logoRemoveBtn   = $('vpOnbLogoRemoveBtn');
    var logoPreviewImg  = $('vpOnbLogoImg');
    var logoPlaceholder = $('vpOnbLogoPlaceholder');
    var logoErrorEl     = $('vpOnbLogoError');
    var selectedLogoFile = null;     // File object if user picked new one
    var hasExistingLogo  = {{ $vpOnbLogoUrl ? 'true' : 'false' }};
    var MAX_LOGO_SIZE    = 2 * 1024 * 1024;  // 2 MB
    var ALLOWED_LOGO_TYPES = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp', 'image/svg+xml'];

    /* Open file picker */
    logoBtn.addEventListener('click', function() { logoInput.click(); });

    /* On file selected */
    logoInput.addEventListener('change', function(e) {
        var file = e.target.files && e.target.files[0];
        if (!file) return;

        var logoWrap = logoInput.closest('.vp-onb-field');

        // Validate type
        if (ALLOWED_LOGO_TYPES.indexOf(file.type) === -1) {
            logoErrorEl.textContent = 'نوع الصورة غير مدعوم. استخدم PNG، JPG، SVG أو WebP';
            logoWrap.classList.add('has-error');
            logoInput.value = '';
            return;
        }
        // Validate size
        if (file.size > MAX_LOGO_SIZE) {
            logoErrorEl.textContent = 'حجم الصورة كبير. الحد الأقصى 2 ميجابايت';
            logoWrap.classList.add('has-error');
            logoInput.value = '';
            return;
        }
        logoWrap.classList.remove('has-error');

        // Preview
        var reader = new FileReader();
        reader.onload = function(ev) {
            logoPreviewImg.src = ev.target.result;
            logoPreviewImg.style.display = 'block';
            if (logoPlaceholder) logoPlaceholder.style.display = 'none';
            logoRemoveBtn.style.display = 'inline-flex';
            logoBtnText.textContent = 'تغيير الشعار';
        };
        reader.readAsDataURL(file);

        selectedLogoFile = file;
        hasExistingLogo = true;
    });

    /* Remove logo */
    logoRemoveBtn.addEventListener('click', function() {
        selectedLogoFile = null;
        hasExistingLogo = false;
        logoInput.value = '';
        logoPreviewImg.src = '';
        logoPreviewImg.style.display = 'none';
        if (logoPlaceholder) logoPlaceholder.style.display = 'flex';
        logoRemoveBtn.style.display = 'none';
        logoBtnText.textContent = 'اختر صورة الشعار';
    });

    /* ───── Step Navigation ───── */
    function goToStep(step) {
        currentStep = step;

        // Hide all step contents
        document.querySelectorAll('.vp-onb-step-content').forEach(function(el) {
            el.classList.remove('active');
        });

        // Show current step
        var content = document.querySelector('[data-step-content="' + step + '"]');
        if (content) content.classList.add('active');

        // Update step indicators
        document.querySelectorAll('.vp-onb-step').forEach(function(el) {
            var s = parseInt(el.dataset.step, 10);
            el.classList.remove('active', 'done');
            if (s < step) el.classList.add('done');
            else if (s === step) el.classList.add('active');
        });

        // Update footer
        backBtn.style.display = step > 1 ? 'inline-flex' : 'none';

        if (step === totalSteps) {
            nextBtn.style.display = 'none';
            submitBtn.style.display = 'inline-flex';
            renderReview();
        } else {
            nextBtn.style.display = 'inline-flex';
            submitBtn.style.display = 'none';
        }

        // Update progress
        var pct = Math.round((step / totalSteps) * 100);
        $('vpOnbProgressFill').style.width = pct + '%';
        $('vpOnbProgressText').textContent = 'الخطوة ' + step + ' من ' + totalSteps;

        // Init map when entering step 2
        if (step === 2 && !map) {
            setTimeout(initMap, 50);
        } else if (step === 2 && map) {
            setTimeout(function() { map.invalidateSize(); }, 50);
        }

        // Scroll body to top
        var body = document.querySelector('.vp-onb-body');
        if (body) body.scrollTop = 0;
    }

    /* ───── Validation ───── */
    function validateStep(step) {
        var ok = true;

        if (step === 1) {
            // Business name
            var nameWrap = nameField.closest('.vp-onb-field');
            if (nameField.value.trim().length < 2) {
                nameWrap.classList.add('has-error');
                ok = false;
            } else {
                nameWrap.classList.remove('has-error');
            }

            // Store name (display name on invoices)
            var storeWrap = storeField.closest('.vp-onb-field');
            if (storeField.value.trim().length < 2) {
                storeWrap.classList.add('has-error');
                ok = false;
            } else {
                storeWrap.classList.remove('has-error');
            }

            // Type
            if (!selectedType) {
                var typeWrap = document.querySelector('[id="vpOnbTypeError"]').closest('.vp-onb-field');
                if (typeWrap) typeWrap.classList.add('has-error');
                ok = false;
            } else {
                var typeWrap2 = document.querySelector('[id="vpOnbTypeError"]').closest('.vp-onb-field');
                if (typeWrap2) typeWrap2.classList.remove('has-error');
            }
        }

        if (step === 2) {
            // Lat/Lng
            if (selectedLat === null || selectedLng === null) {
                alert('يرجى تحديد موقع نشاطك على الخريطة (اضغط على الخريطة أو استخدم موقعك الحالي)');
                ok = false;
            }
            // Address
            var addrWrap = addrField.closest('.vp-onb-field');
            if (addrField.value.trim().length < 3) {
                addrWrap.classList.add('has-error');
                ok = false;
            } else {
                addrWrap.classList.remove('has-error');
            }
        }

        return ok;
    }

    /* ───── Type Cards ───── */
    document.querySelectorAll('.vp-onb-type').forEach(function(card) {
        card.addEventListener('click', function() {
            document.querySelectorAll('.vp-onb-type').forEach(function(c) {
                c.classList.remove('selected');
            });
            card.classList.add('selected');
            selectedType = card.dataset.type;
            card.querySelector('input[type="radio"]').checked = true;

            // Clear error
            var wrap = document.querySelector('[id="vpOnbTypeError"]').closest('.vp-onb-field');
            if (wrap) wrap.classList.remove('has-error');
        });
    });

    /* ───── Leaflet Map ───── */
    function initMap() {
        if (typeof L === 'undefined') {
            console.error('Leaflet not loaded');
            return;
        }

        var startLat = selectedLat !== null ? selectedLat : DEFAULT_LAT;
        var startLng = selectedLng !== null ? selectedLng : DEFAULT_LNG;
        var startZoom = selectedLat !== null ? LOCATED_ZOOM : DEFAULT_ZOOM;

        map = L.map('vpOnbMap', {
            center: [startLat, startLng],
            zoom: startZoom,
            zoomControl: true,
            attributionControl: true
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            maxZoom: 19
        }).addTo(map);

        // Custom marker icon
        var customIcon = L.divIcon({
            className: 'vp-onb-marker-wrap',
            html: '<div class="vp-onb-marker"></div>',
            iconSize: [36, 48],
            iconAnchor: [18, 48]
        });

        // If we already have a saved location, place the marker
        if (selectedLat !== null && selectedLng !== null) {
            marker = L.marker([selectedLat, selectedLng], {
                draggable: true,
                icon: customIcon
            }).addTo(map);
            marker.on('dragend', onMarkerMove);
            updateCoords(selectedLat, selectedLng);
        }

        // Click on map to drop/move the marker
        map.on('click', function(e) {
            placeMarker(e.latlng.lat, e.latlng.lng);
        });

        // Recalculate size after a brief delay (modal might have been hidden)
        setTimeout(function() { map.invalidateSize(); }, 100);
    }

    function placeMarker(lat, lng) {
        var customIcon = L.divIcon({
            className: 'vp-onb-marker-wrap',
            html: '<div class="vp-onb-marker"></div>',
            iconSize: [36, 48],
            iconAnchor: [18, 48]
        });

        if (!marker) {
            marker = L.marker([lat, lng], { draggable: true, icon: customIcon }).addTo(map);
            marker.on('dragend', onMarkerMove);
        } else {
            marker.setLatLng([lat, lng]);
        }
        updateCoords(lat, lng);
        reverseGeocode(lat, lng);
    }

    function onMarkerMove(e) {
        var pos = e.target.getLatLng();
        updateCoords(pos.lat, pos.lng);
        reverseGeocode(pos.lat, pos.lng);
    }

    function updateCoords(lat, lng) {
        selectedLat = lat;
        selectedLng = lng;
        latLabel.textContent = lat.toFixed(6);
        lngLabel.textContent = lng.toFixed(6);
    }

    /* ───── Nominatim Reverse Geocoding ───── */
    var geocodeTimer = null;
    function reverseGeocode(lat, lng) {
        if (geocodeTimer) clearTimeout(geocodeTimer);
        geocodeTimer = setTimeout(function() {
            var url = 'https://nominatim.openstreetmap.org/reverse?format=json'
                    + '&lat=' + encodeURIComponent(lat)
                    + '&lon=' + encodeURIComponent(lng)
                    + '&accept-language=ar&zoom=18&addressdetails=1';

            fetch(url, { headers: { 'Accept': 'application/json' } })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (data && data.display_name && !addrField.dataset.userEdited) {
                        addrField.value = data.display_name;
                    }
                })
                .catch(function() { /* silent */ });
        }, 350);
    }

    // Mark address as user-edited (don't overwrite from reverse geocoding)
    addrField.addEventListener('input', function() {
        this.dataset.userEdited = '1';
    });

    /* ───── Geolocation API ───── */
    $('vpOnbLocateBtn').addEventListener('click', function() {
        if (!navigator.geolocation) {
            alert('متصفّحك لا يدعم تحديد الموقع. يمكنك تحديده يدوياً على الخريطة.');
            return;
        }
        loading.classList.remove('hidden');
        navigator.geolocation.getCurrentPosition(
            function(pos) {
                loading.classList.add('hidden');
                var lat = pos.coords.latitude;
                var lng = pos.coords.longitude;
                map.setView([lat, lng], LOCATED_ZOOM);
                placeMarker(lat, lng);
            },
            function(err) {
                loading.classList.add('hidden');
                var msgs = {
                    1: 'رفضتَ إذن الوصول للموقع. يمكنك تحديده يدوياً على الخريطة.',
                    2: 'تعذّر تحديد الموقع. تأكّد من تفعيل GPS وحاول مرّة أخرى.',
                    3: 'انتهت مهلة تحديد الموقع. حاول مرّة أخرى.'
                };
                alert(msgs[err.code] || 'حدث خطأ أثناء تحديد الموقع.');
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );
    });

    /* ───── Review Renderer ───── */
    function renderReview() {
        // Logo preview row
        var logoItem = $('vpOnbReviewLogoItem');
        var logoImgPreview = $('vpOnbReviewLogoImg');
        if (hasExistingLogo && logoPreviewImg && logoPreviewImg.src) {
            logoImgPreview.src = logoPreviewImg.src;
            logoItem.style.display = 'flex';
        } else {
            logoItem.style.display = 'none';
        }

        $('vpOnbReviewName').textContent = nameField.value.trim() || '—';
        $('vpOnbReviewStore').textContent = storeField.value.trim() || '—';

        var t = $('vpOnbReviewType');
        if (selectedType && typeNames[selectedType]) {
            t.textContent = typeNames[selectedType];
            t.classList.remove('vp-onb-review-value-empty');
        } else {
            t.textContent = 'لم يُحدَّد';
            t.classList.add('vp-onb-review-value-empty');
        }

        var cr = $('vpOnbReviewCr');
        if (crField.value.trim()) {
            cr.textContent = crField.value.trim();
            cr.classList.remove('vp-onb-review-value-empty');
        } else {
            cr.textContent = 'غير مُضاف (اختياري)';
            cr.classList.add('vp-onb-review-value-empty');
        }

        var addr = $('vpOnbReviewAddress');
        var addressText = addrField.value.trim();
        if (addressText && selectedLat !== null) {
            addr.innerHTML = addressText + '<br><span style="font-size: 11.5px; color: #98A2B3; font-weight: 600; direction: ltr; display: inline-block;">'
                           + selectedLat.toFixed(5) + ', ' + selectedLng.toFixed(5) + '</span>';
            addr.classList.remove('vp-onb-review-value-empty');
        } else {
            addr.textContent = 'لم يُحدَّد';
            addr.classList.add('vp-onb-review-value-empty');
        }
    }

    /* ───── Edit shortcuts in review ───── */
    document.querySelectorAll('.vp-onb-review-edit').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var step = parseInt(this.dataset.goto, 10);
            if (step) goToStep(step);
        });
    });

    /* ───── Nav Buttons ───── */
    nextBtn.addEventListener('click', function() {
        if (!validateStep(currentStep)) return;
        if (currentStep < totalSteps) goToStep(currentStep + 1);
    });

    backBtn.addEventListener('click', function() {
        if (currentStep > 1) goToStep(currentStep - 1);
    });

    /* ───── Submit ───── */
    submitBtn.addEventListener('click', function() {
        if (!validateStep(2) || !validateStep(1)) {
            // Re-validate earlier steps
            if (!validateStep(1)) goToStep(1);
            else if (!validateStep(2)) goToStep(2);
            return;
        }

        var btn = submitBtn;
        var txt = $('vpOnbSubmitText');
        btn.disabled = true;
        txt.textContent = 'جارٍ الحفظ...';

        // Use FormData to support file upload (multipart/form-data)
        var fd = new FormData();
        fd.append('_token',           CSRF);
        fd.append('business_name',    nameField.value.trim());
        fd.append('store_name',       storeField.value.trim());
        fd.append('business_type',    selectedType);
        fd.append('cr_number',        crField.value.trim());
        fd.append('business_lat',     selectedLat);
        fd.append('business_lng',     selectedLng);
        fd.append('business_address', addrField.value.trim());
        if (selectedLogoFile) {
            fd.append('logo', selectedLogoFile);
        }

        fetch(SAVE_URL, {
            method: 'POST',
            headers: {
                // DO NOT set Content-Type — browser sets it with the boundary
                'Accept': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: fd,
            credentials: 'same-origin'
        })
        .then(function(r) {
            if (!r.ok) {
                return r.json().then(function(j) {
                    throw new Error(j.message || ('HTTP ' + r.status));
                }).catch(function() { throw new Error('HTTP ' + r.status); });
            }
            return r.json();
        })
        .then(function(data) {
            if (data && (data.success || data.status === 'success' || data.message)) {
                showSuccess();
            } else {
                throw new Error('Unexpected response');
            }
        })
        .catch(function(err) {
            btn.disabled = false;
            txt.textContent = 'إتمام وحفظ البيانات';
            alert('تعذّر حفظ البيانات. تأكد من اتصالك بالإنترنت وحاول مرّة أخرى.\n\n' + (err.message || ''));
        });
    });

    function showSuccess() {
        document.querySelectorAll('.vp-onb-step-content').forEach(function(el) {
            el.classList.remove('active');
        });
        var s = document.querySelector('[data-step-content="success"]');
        if (s) s.classList.add('active');

        // Hide footer
        $('vpOnbFooter').style.display = 'none';

        // Reload after a brief celebration
        setTimeout(function() {
            window.location.reload();
        }, 1800);
    }

    /* ───── Init ───── */
    // Set initial coord labels if we already have a saved location
    if (selectedLat !== null && selectedLng !== null) {
        latLabel.textContent = (+selectedLat).toFixed(6);
        lngLabel.textContent = (+selectedLng).toFixed(6);
    }

    // Prevent body scroll while modal open
    document.body.style.overflow = 'hidden';

})();
</script>
@endpush

@endif
