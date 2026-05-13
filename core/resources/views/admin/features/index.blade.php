@extends('admin.layouts.app')

@section('panel')
<div class="panel-content" dir="rtl" style="padding: 1.5rem;">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="m-0">إدارة المميزات والباقات</h4>
            <p class="text-muted small m-0 mt-1">التحكّم في المميزات المتاحة لكل باقة — تأثير فوري على كل المستخدمين</p>
        </div>
    </div>

    <div class="row g-3 mb-4">
        @foreach($plans as $plan)
            @php
                $count = 0;
                foreach ($features as $feature) {
                    if (isset($matrix[$feature->id][$plan->id]) && $matrix[$feature->id][$plan->id]) {
                        $count++;
                    }
                }
                $percentage = $features->count() > 0 ? round(($count / $features->count()) * 100, 1) : 0;
            @endphp
            <div class="col-md-3 col-6">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted small">{{ $plan->name }}</h6>
                        <h3 style="color: #10b981;">{{ $count }} / {{ $features->count() }}</h3>
                        <small class="text-muted">{{ $percentage }}% مفعّلة</small>
                        <div class="progress mt-2" style="height: 5px;">
                            <div class="progress-bar bg-success" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card">
        <div class="card-header">
            <strong>المصفوفة الكاملة</strong>
            <span class="text-muted small">— اضغط ☑️ لتفعيل/إلغاء ميزة لباقة</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: #f8fafc;">
                        <tr>
                            <th style="min-width: 250px;">الميزة</th>
                            @foreach($plans as $plan)
                                <th class="text-center" style="min-width: 120px;">
                                    {{ $plan->name }}
                                    <br>
                                    <small class="text-muted">{{ number_format($plan->monthly_price, 0) }} ر</small>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php $currentCategory = null; @endphp
                        @foreach($features as $feature)
                            @if($feature->category !== $currentCategory)
                                @php $currentCategory = $feature->category; @endphp
                                <tr style="background: #f1f5f9;">
                                    <td colspan="{{ count($plans) + 1 }}" class="fw-bold py-2">
                                        <i class="las la-folder"></i> {{ $categories[$feature->category] ?? $feature->category }}
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="{{ $feature->icon }}"></i>
                                        <div>
                                            <strong>{{ $feature->name_ar }}</strong>
                                            @if($feature->is_premium)
                                                <span class="badge bg-warning text-dark">Premium</span>
                                            @endif
                                            <br>
                                            <small class="text-muted">{{ $feature->code }}</small>
                                        </div>
                                    </div>
                                </td>
                                @foreach($plans as $plan)
                                    @php $isEnabled = $matrix[$feature->id][$plan->id] ?? false; @endphp
                                    <td class="text-center">
                                        <div class="form-check form-switch d-inline-block">
                                            <input class="form-check-input feature-toggle"
                                                type="checkbox"
                                                data-feature-id="{{ $feature->id }}"
                                                data-plan-id="{{ $plan->id }}"
                                                {{ $isEnabled ? 'checked' : '' }}
                                                style="cursor: pointer; width: 3rem; height: 1.5rem;">
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="alert alert-info mt-3">
        <i class="las la-info-circle"></i>
        <strong>ملاحظة:</strong> أيّ تغيير ينطبق فوراً على كل المستخدمين في هذي الباقة.
    </div>

</div>

@push('script')
<script>
const toggleUrl = "{{ route('admin.features.toggle') }}";
const csrfToken = "{{ csrf_token() }}";

document.querySelectorAll('.feature-toggle').forEach(toggle => {
    toggle.addEventListener('change', async function() {
        const featureId = this.dataset.featureId;
        const planId = this.dataset.planId;
        const isEnabled = this.checked;

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
    toast.className = 'alert alert-' + (type === 'success' ? 'success' : 'danger') + ' position-fixed top-0 end-0 m-3';
    toast.style.zIndex = 9999;
    toast.innerText = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 2000);
}
</script>
@endpush
@endsection
