@extends($activeTemplate . 'layouts.master')

@section('panel')
<div style="padding: 20px; font-family: 'Cairo','Tajawal',sans-serif; direction: rtl;">

    {{-- ═══════ Header ═══════ --}}
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 28px; font-weight: 900; margin: 0; color: #0F172A;">
            ➕ إنشاء خطة تقسيط جديدة
        </h1>
        <p style="color: #64748B; margin: 4px 0 0;">قسّط فاتورة بيع على دفعات متعددة</p>
    </div>

    <form action="{{ route('user.installment.store') }}" method="POST">
        @csrf

        {{-- ═══════ Card 1: اختيار الفاتورة ═══════ --}}
        <div style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #E2E8F0; margin-bottom: 20px;">
            <h3 style="font-size: 18px; font-weight: 700; margin: 0 0 20px; color: #0F172A;">📄 الفاتورة</h3>

            @if($sales->count() > 0)
                <div>
                    <label style="display: block; font-weight: 700; margin-bottom: 8px; color: #334155;">
                        اختر الفاتورة <span style="color: #EF4444;">*</span>
                    </label>
                    <select name="sale_id" id="saleSelect" required onchange="updateSaleInfo()"
                            style="width: 100%; padding: 12px 16px; border: 1px solid #E2E8F0; border-radius: 8px; font-family: inherit; font-size: 15px;">
                        <option value="">-- اختر فاتورة --</option>
                        @foreach($sales as $sale)
                            <option value="{{ $sale->id }}" 
                                    data-invoice="{{ $sale->invoice_no }}"
                                    data-customer="{{ $sale->customer->name ?? '-' }}"
                                    data-total="{{ $sale->total }}"
                                    data-date="{{ $sale->created_at->format('Y-m-d') }}">
                                {{ $sale->invoice_no }} - {{ $sale->customer->name ?? 'بدون عميل' }} - {{ number_format($sale->total, 2) }} ريال
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- عرض معلومات الفاتورة المختارة --}}
                <div id="saleInfo" style="display: none; margin-top: 16px; padding: 16px; background: #F8FAFC; border-radius: 12px; border: 1px solid #E2E8F0;">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
                        <div>
                            <div style="color: #64748B; font-size: 12px; margin-bottom: 4px;">رقم الفاتورة</div>
                            <div id="invoiceNo" style="font-weight: 700;">-</div>
                        </div>
                        <div>
                            <div style="color: #64748B; font-size: 12px; margin-bottom: 4px;">العميل</div>
                            <div id="customerName" style="font-weight: 700;">-</div>
                        </div>
                        <div>
                            <div style="color: #64748B; font-size: 12px; margin-bottom: 4px;">الإجمالي</div>
                            <div id="saleTotal" style="font-weight: 700; color: #10B981; font-size: 18px;">-</div>
                        </div>
                        <div>
                            <div style="color: #64748B; font-size: 12px; margin-bottom: 4px;">التاريخ</div>
                            <div id="saleDate" style="font-weight: 700;">-</div>
                        </div>
                    </div>
                </div>

            @else
                <div style="padding: 40px; text-align: center; background: #FEF3C7; border-radius: 12px; border: 1px solid #FDE68A;">
                    <div style="font-size: 48px; margin-bottom: 12px;">⚠️</div>
                    <h4 style="color: #92400E; margin: 0 0 8px;">لا توجد فواتير متاحة</h4>
                    <p style="color: #B45309; margin: 0;">جميع الفواتير تم تقسيطها أو لا توجد فواتير بيع حالياً.</p>
                    <a href="{{ route('user.sale.add') }}" 
                       style="display: inline-block; margin-top: 16px; background: #F59E0B; color: white; padding: 10px 24px; border-radius: 8px; text-decoration: none; font-weight: 700;">
                        إنشاء فاتورة جديدة
                    </a>
                </div>
            @endif

        </div>

        @if($sales->count() > 0)
        {{-- ═══════ Card 2: تفاصيل التقسيط ═══════ --}}
        <div style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #E2E8F0; margin-bottom: 20px;">
            <h3 style="font-size: 18px; font-weight: 700; margin: 0 0 20px; color: #0F172A;">💳 تفاصيل التقسيط</h3>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 16px;">

                {{-- عدد الأقساط --}}
                <div>
                    <label style="display: block; font-weight: 700; margin-bottom: 8px; color: #334155;">
                        عدد الأقساط <span style="color: #EF4444;">*</span>
                    </label>
                    <input type="number" name="number_of_installments" id="numInstallments" 
                           min="2" max="36" value="3" required oninput="calculateInstallment()"
                           style="width: 100%; padding: 10px 16px; border: 1px solid #E2E8F0; border-radius: 8px; font-family: inherit;">
                    <small style="color: #64748B; font-size: 12px;">من 2 إلى 36 قسط</small>
                </div>

                {{-- تاريخ البدء --}}
                <div>
                    <label style="display: block; font-weight: 700; margin-bottom: 8px; color: #334155;">
                        تاريخ أول قسط <span style="color: #EF4444;">*</span>
                    </label>
                    <input type="date" name="start_date" value="{{ date('Y-m-d', strtotime('+1 month')) }}" required
                           style="width: 100%; padding: 10px 16px; border: 1px solid #E2E8F0; border-radius: 8px; font-family: inherit;">
                </div>

                {{-- التكرار --}}
                <div>
                    <label style="display: block; font-weight: 700; margin-bottom: 8px; color: #334155;">
                        تكرار الدفعات <span style="color: #EF4444;">*</span>
                    </label>
                    <select name="frequency" required
                            style="width: 100%; padding: 10px 16px; border: 1px solid #E2E8F0; border-radius: 8px; font-family: inherit;">
                        <option value="monthly" selected>شهري</option>
                        <option value="weekly">أسبوعي</option>
                        <option value="daily">يومي</option>
                        <option value="yearly">سنوي</option>
                    </select>
                </div>

            </div>

            {{-- معاينة مبلغ القسط --}}
            <div id="installmentPreview" style="display: none; margin-top: 20px; padding: 16px; background: #ECFDF5; border-radius: 12px; border: 1px solid #A7F3D0;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="color: #065F46; font-size: 13px; margin-bottom: 4px;">مبلغ كل قسط (تقريبي)</div>
                        <div id="installmentAmount" style="font-size: 24px; font-weight: 900; color: #10B981;">-</div>
                    </div>
                    <div style="font-size: 40px;">💰</div>
                </div>
            </div>

        </div>

        {{-- ═══════ Card 3: ملاحظات ═══════ --}}
        <div style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #E2E8F0; margin-bottom: 20px;">
            <h3 style="font-size: 18px; font-weight: 700; margin: 0 0 12px; color: #0F172A;">📝 ملاحظات</h3>
            <textarea name="notes" rows="3" placeholder="ملاحظات إضافيّة (اختياري)..."
                      style="width: 100%; padding: 12px; border: 1px solid #E2E8F0; border-radius: 8px; font-family: inherit; resize: vertical;"></textarea>
        </div>

        {{-- ═══════ Actions ═══════ --}}
        <div style="display: flex; gap: 12px; justify-content: flex-end;">
            <a href="{{ route('user.installment.list') }}"
               style="background: #F1F5F9; color: #475569; padding: 12px 28px; border-radius: 10px; text-decoration: none; font-weight: 700;">
                إلغاء
            </a>
            <button type="submit"
                    style="background: linear-gradient(135deg, #10B981, #059669); color: white; padding: 12px 32px; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 12px rgba(16,185,129,0.3);">
                ✅ إنشاء خطة التقسيط
            </button>
        </div>
        @endif

    </form>

</div>

<script>
// عرض معلومات الفاتورة المختارة
function updateSaleInfo() {
    const select = document.getElementById('saleSelect');
    const option = select.options[select.selectedIndex];
    
    if (!option.value) {
        document.getElementById('saleInfo').style.display = 'none';
        document.getElementById('installmentPreview').style.display = 'none';
        return;
    }

    document.getElementById('invoiceNo').textContent = option.dataset.invoice;
    document.getElementById('customerName').textContent = option.dataset.customer;
    document.getElementById('saleTotal').textContent = parseFloat(option.dataset.total).toFixed(2) + ' ريال';
    document.getElementById('saleDate').textContent = option.dataset.date;
    
    document.getElementById('saleInfo').style.display = 'block';
    calculateInstallment();
}

// حساب مبلغ القسط
function calculateInstallment() {
    const select = document.getElementById('saleSelect');
    const option = select.options[select.selectedIndex];
    const numInstallments = document.getElementById('numInstallments').value;

    if (!option.value || !numInstallments || numInstallments < 2) {
        document.getElementById('installmentPreview').style.display = 'none';
        return;
    }

    const total = parseFloat(option.dataset.total);
    const installmentAmount = (total / numInstallments).toFixed(2);

    document.getElementById('installmentAmount').textContent = installmentAmount + ' ريال';
    document.getElementById('installmentPreview').style.display = 'block';
}
</script>

@endsection