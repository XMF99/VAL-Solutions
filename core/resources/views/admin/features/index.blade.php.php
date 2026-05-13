@extends('admin.layouts.app')

@section('panel')
<div class="panel-content" dir="rtl" style="padding: 1.5rem;">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="m-0">💎 إدارة مميزات الباقات</h4>
            <p class="text-muted small m-0 mt-1">التحكّم في المميزات المتاحة لكل باقة — تأثير فوري على كل المستخدمين</p>
        </div>
        <a href="{{ route('admin.subscription.plan.list') }}" class="btn btn-outline-secondary btn-sm">
            <i class="las la-arrow-right"></i> إدارة الباقات
        </a>
    </div>

    @php
        $totalFeatures = $features->count();
        $totalPlanFeatures = 0;
        foreach ($matrix as $featureId => $planArr) {
            foreach ($planArr as $planId => $enabled) {
                if ($enabled) $totalPlanFeatures++;
            }
        }
        $planIcons = [1 => '📦', 2 => '⭐', 3 => '🏆', 4 => '👑'];
        $planColors = [1 => '#64748b', 2 => '#3b82f6', 3 => '#8b5cf6', 4 => '#f59e0b'];
    @endphp

    {{-- Overview Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="card border-info">
                <div class="card-body text-center">
                    <h6 class="text-muted small mb-1">إجمالي المميزات</h6>
                    <h2 style="color: #3b82f6;">{{ $totalFeatures }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-success">
                <div class="card-body text-center">
                    <h6 class="text-muted small mb-1">عدد الباقات</h6>
                    <h2 style="color: #10b981;">{{ $plans->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <h6 class="text-muted small mb-1">الفئات</h6>
                    <h2 style="color: #f59e0b;">{{ count($categories) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="text-muted small mb-1">إجمالي الروابط</h6>
                    <h2 style="color: #8b5cf6;">{{ $totalPlanFeatures }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Plans with their features --}}
    @foreach($plans as $plan)
        @php
            $planCount = 0;
            foreach ($features as $feature) {
                if (isset($matrix[$feature->id][$plan->id]) && $matrix[$feature->id][$plan->id]) {
                    $planCount++;
                }
            }
            $percentage = $totalFeatures > 0 ? round(($planCount / $totalFeatures) * 100, 1) : 0;
            $planIcon = $planIcons[$plan->id] ?? '📋';
            $planColor = $planColors[$plan->id] ?? '#64748b';
        @endphp

        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center" style="cursor: pointer;" onclick="togglePlan({{ $plan->id }})">
                <div class="d-flex align-items-center gap-3">
                    <span style="font-size: 2rem;">{{ $planIcon }}</span>
                    <div>
                        <h5 class="m-0">{{ $plan->name }}</h5>
                        <small class="text-muted">{{ number_format($plan->monthly_price, 0) }} ر/شهر · {{ number_format($plan->yearly_price, 0) }} ر/سنة</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-end">
                        <h4 class="m-0" style="color: {{ $planColor }};">{{ $planCount }}/{{ $totalFeatures }}</h4>
                        <small class="text-muted">{{ $percentage }}% مفعّلة</small>
                    </div>
                    <i class="las la-chevron-down toggle-icon-{{ $plan->id }}" style="font-size: 1.5rem; transition: transform 0.3s;"></i>
                </div>
            </div>

            <div class="progress" style="height: 4px; border-radius: 0;">
                <div class="progress-bar" style="width: {{ $percentage }}%; background: {{ $planColor }};"></div>
            </div>

            <div class="card-body plan-body-{{ $plan->id }}" id="plan-body-{{ $plan->id }}" style="display: {{ $plan->id == 1 ? 'block' : 'none' }};">
                @php $grouped = $features->groupBy('category'); @endphp
                @foreach($grouped as $category => $categoryFeatures)
                    @php
                        $catEnabled = 0;
                        foreach ($categoryFeatures as $f) {
                            if (isset($matrix[$f->id][$plan->id]) && $matrix[$f->id][$plan->id]) $catEnabled++;
                        }
                    @endphp
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                            <h6 class="m-0">
                                <i class="las la-folder text-warning"></i>
                                {{ $categories[$category] ?? $category }}
                                <span class="badge bg-light text-dark ms-2">{{ $catEnabled }}/{{ $categoryFeatures->count() }}</span>
                            </h6>
                        </div>
                        <div class="row g-2">
                            @foreach($categoryFeatures as $feature)
                                @php $isEnabled = $matrix[$feature->id][$plan->id] ?? false; @endphp
                                <div class="col-md-6 col-lg-4">
                                    <div class="d-flex align-items-center gap-2 p-2 rounded feature-card" style="border: 1px solid {{ $isEnabled ? '#86efac' : '#e5e7eb' }}; background: {{ $isEnabled ? '#d1fae5' : '#f9fafb' }};">
                                        <div class="form-check form-switch m-0">
                                            <input class="form-check-input feature-toggle" type="checkbox" data-feature-id="{{ $feature->id }}" data-plan-id="{{ $plan->id }}" {{ $isEnabled ? 'checked' : '' }} style="cursor: pointer;">
                                        </div>
                                        <i class="{{ $feature->icon }}" style="font-size: 1.2rem; color: {{ $isEnabled ? '#10b981' : '#94a3b8' }};"></i>
                                        <div class="flex-grow-1">
                                            <div class="small fw-bold">{{ $feature->name_ar }}</div>
                                            @if($feature->is_premium)
                                                <span class="badge bg-warning text-dark" style="font-size: 0.65rem;">Premium</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <div class="alert alert-info mt-3">
        <i class="las la-info-circle"></i>
        <strong>ملاحظة:</strong> أيّ تغيير ينطبق فوراً على كل المستخدمين في هذي الباقة.
    </div>

</div>

@push('script')
<script>
const toggleUrl = "{{ route('admin.features.toggle') }}";
const csrfToken = "{{ csrf_token() }}";

function togglePlan(planId) {
    const body = document.getElementById('plan-body-' + planId);
    const icon = document.querySelector('.toggle-icon-' + planId);
    if (body.style.display === 'none') {
        body.style.display = 'block';
        if (icon) icon.style.transform = 'rotate(180deg)';
    } else {
        body.style.display = 'none';
        if (icon) icon.style.transform = 'rotate(0deg)';
    }
}

document.querySelectorAll('.feature-toggle').forEach(toggle => {
    toggle.addEventListener('change', async function() {
        const featureId = this.dataset.featureId;
        const planId = this.dataset.planId;
        const isEnabled = this.checked;
        const card = this.closest('.feature-card');

        try {
            const response = await fetch(toggleUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    feature_id: featureId,
                    plan_id: planId,
                    is_enabled: isEnabled ? 1 : 0,
                })
            });

            const data = await response.json();
            if (data.success) {
                showToast('تمّ التحديث', 'success');
                if (card) {
                    if (isEnabled) {
                        card.style.background = '#d1fae5';
                        card.style.borderColor = '#86efac';
                    } else {
                        card.style.background = '#f9fafb';
                        card.style.borderColor = '#e5e7eb';
                    }
                }
            } else {
                showToast('فشل التحديث', 'error');
                this.checked = !isEnabled;
            }
        } catch (e) {
            showToast('خطأ في الاتّصال', 'error');
            this.checked = !isEnabled;
        }
    });
});

function showToast(message, type) {
    const toast = document.createElement('div');
    toast.className = 'alert alert-' + (type === 'success' ? 'success' : 'danger') + ' position-fixed top-0 end-0 m-3 shadow';
    toast.style.zIndex = 9999;
    toast.style.minWidth = '220px';
    toast.innerText = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 2000);
}
</script>
@endpush
@endsection