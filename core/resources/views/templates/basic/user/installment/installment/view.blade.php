@extends($activeTemplate . 'layouts.master')

@section('panel')
<div style="padding: 20px; font-family: 'Cairo','Tajawal',sans-serif; direction: rtl;">

    {{-- ═══════ Header ═══════ --}}
    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 28px; font-weight: 900; margin: 0; color: #0F172A;">
                💳 خطة تقسيط: {{ $plan->sale->invoice_no }}
            </h1>
            <p style="color: #64748B; margin: 4px 0 0;">تفاصيل الدفعات والمدفوعات</p>
        </div>

        <a href="{{ route('user.installment.list') }}"
           style="background: #F1F5F9; color: #475569; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 700;">
            ← العودة للقائمة
        </a>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px;">

        {{-- ═══════ Left: Main Content ═══════ --}}
        <div>
            {{-- Card 1: Plan Info --}}
            <div style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #E2E8F0; margin-bottom: 20px;">
                <h3 style="font-size: 18px; font-weight: 700; margin: 0 0 20px; color: #0F172A;">📊 معلومات الخطة</h3>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                    <div>
                        <div style="color: #64748B; font-size: 13px; margin-bottom: 4px;">رقم الفاتورة</div>
                        <div style="font-weight: 700; color: #4F46E5;">{{ $plan->sale->invoice_no }}</div>
                    </div>
                    <div>
                        <div style="color: #64748B; font-size: 13px; margin-bottom: 4px;">العميل</div>
                        <div style="font-weight: 700;">{{ $plan->sale->customer->name ?? '-' }}</div>
                    </div>
                    <div>
                        <div style="color: #64748B; font-size: 13px; margin-bottom: 4px;">المبلغ الكلي</div>
                        <div style="font-weight: 700; font-size: 18px; color: #10B981;">{{ number_format($plan->total_amount, 2) }}</div>
                    </div>
                    <div>
                        <div style="color: #64748B; font-size: 13px; margin-bottom: 4px;">عدد الأقساط</div>
                        <div style="font-weight: 700;">{{ $plan->number_of_installments }}</div>
                    </div>
                    <div>
                        <div style="color: #64748B; font-size: 13px; margin-bottom: 4px;">التكرار</div>
                        <div style="font-weight: 700;">{{ $plan->frequency_name }}</div>
                    </div>
                    <div>
                        <div style="color: #64748B; font-size: 13px; margin-bottom: 4px;">تاريخ البدء</div>
                        <div style="font-weight: 700;">{{ $plan->start_date->format('Y-m-d') }}</div>
                    </div>
                </div>

                {{-- Progress Bar --}}
                <div style="margin-top: 24px; padding: 20px; background: #F8FAFC; border-radius: 12px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                        <span style="font-weight: 700; color: #0F172A;">التقدّم</span>
                        <span style="font-size: 20px; font-weight: 900; color: #10B981;">{{ $plan->completion_percentage }}%</span>
                    </div>
                    <div style="height: 16px; background: #E2E8F0; border-radius: 999px; overflow: hidden;">
                        <div style="height: 100%; background: linear-gradient(90deg, #10B981, #059669); width: {{ $plan->completion_percentage }}%; transition: width 0.3s;"></div>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-top: 12px;">
                        <div>
                            <div style="font-size: 12px; color: #64748B;">مدفوع</div>
                            <div style="font-weight: 700; color: #10B981;">{{ number_format($plan->paid_amount, 2) }}</div>
                        </div>
                        <div style="text-align: left;">
                            <div style="font-size: 12px; color: #64748B;">متبقي</div>
                            <div style="font-weight: 700; color: #EF4444;">{{ number_format($plan->remaining_amount, 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 2: Payments Table --}}
            <div style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #E2E8F0;">
                <h3 style="font-size: 18px; font-weight: 700; margin: 0 0 16px; color: #0F172A;">📋 الدفعات</h3>

                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead style="background: #F8FAFC;">
                            <tr>
                                <th style="padding: 12px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">القسط</th>
                                <th style="padding: 12px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">المبلغ</th>
                                <th style="padding: 12px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">تاريخ الاستحقاق</th>
                                <th style="padding: 12px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">تاريخ الدفع</th>
                                <th style="padding: 12px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">الحالة</th>
                                <th style="padding: 12px; text-align: center; font-size: 13px; font-weight: 700; color: #64748B;">إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($plan->payments as $payment)
                            <tr style="border-top: 1px solid #F1F5F9;">
                                <td style="padding: 12px; font-weight: 700;">القسط {{ $payment->payment_number }}</td>
                                <td style="padding: 12px; font-weight: 700;">{{ number_format($payment->amount, 2) }}</td>
                                <td style="padding: 12px;">{{ $payment->due_date->format('Y-m-d') }}</td>
                                <td style="padding: 12px;">{{ $payment->paid_date?->format('Y-m-d') ?? '-' }}</td>
                                <td style="padding: 12px;">
                                    <span style="background: {{ $payment->status_color === 'success' ? '#D1FAE5' : ($payment->status_color === 'danger' ? '#FEE2E2' : ($payment->status_color === 'warning' ? '#FEF3C7' : '#F3F4F6')) }};
                                                 color: {{ $payment->status_color === 'success' ? '#065F46' : ($payment->status_color === 'danger' ? '#991B1B' : ($payment->status_color === 'warning' ? '#92400E' : '#374151')) }};
                                                 padding: 4px 12px; border-radius: 999px; font-size: 12px; font-weight: 700;">
                                        {{ $payment->status_name }}
                                    </span>
                                    @if($payment->is_overdue)
                                        <small style="display: block; color: #EF4444; font-size: 11px; margin-top: 2px;">{{ $payment->days_remaining_text }}</small>
                                    @endif
                                </td>
                                <td style="padding: 12px; text-align: center;">
                                    @if($payment->status === 'pending')
                                        <button onclick="showPaymentModal({{ $payment->id }})"
                                                style="background: #10B981; color: white; padding: 6px 12px; border: none; border-radius: 6px; font-size: 12px; cursor: pointer; font-weight: 700;">
                                            ✅ تسجيل دفع
                                        </button>
                                    @elseif($payment->status === 'paid')
                                        <span style="color: #10B981; font-size: 12px;">{{ $payment->payment_method ?? 'مدفوع' }}</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @if($plan->notes)
            <div style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #E2E8F0; margin-top: 20px;">
                <h3 style="font-size: 18px; font-weight: 700; margin: 0 0 12px; color: #0F172A;">📝 ملاحظات</h3>
                <p style="color: #334155; line-height: 1.6; margin: 0;">{{ $plan->notes }}</p>
            </div>
            @endif
        </div>

        {{-- ═══════ Right: Summary & Actions ═══════ --}}
        <div>
            {{-- Summary Card --}}
            <div style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #E2E8F0; margin-bottom: 20px;">
                <h3 style="font-size: 18px; font-weight: 700; margin: 0 0 16px; color: #0F172A;">💰 الملخص</h3>

                <div style="margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #F1F5F9;">
                    <div style="color: #64748B; font-size: 13px; margin-bottom: 4px;">الحالة</div>
                    <span style="background: {{ $plan->status_color === 'success' ? '#D1FAE5' : ($plan->status_color === 'info' ? '#DBEAFE' : '#F3F4F6') }};
                                 color: {{ $plan->status_color === 'success' ? '#065F46' : ($plan->status_color === 'info' ? '#1E40AF' : '#374151') }};
                                 padding: 6px 16px; border-radius: 999px; font-size: 14px; font-weight: 700; display: inline-block;">
                        {{ $plan->status_name }}
                    </span>
                </div>

                <div style="margin-bottom: 12px;">
                    <div style="color: #64748B; font-size: 13px; margin-bottom: 4px;">الأقساط المدفوعة</div>
                    <div style="font-weight: 900; font-size: 20px; color: #10B981;">
                        {{ $plan->paid_payments_count }} / {{ $plan->number_of_installments }}
                    </div>
                </div>
            </div>

            {{-- Danger Zone --}}
            <div style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #FEE2E2;">
                <h3 style="font-size: 18px; font-weight: 700; margin: 0 0 16px; color: #991B1B;">⚠️ منطقة الخطر</h3>

                <form action="{{ route('user.installment.delete', $plan->id) }}" method="POST"
                      onsubmit="return confirm('هل أنت متأكّد من حذف خطة التقسيط؟ لا يمكن التراجع.')">
                    @csrf
                    <button type="submit"
                            style="width: 100%; background: #EF4444; color: white; padding: 12px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer;">
                        🗑️ حذف الخطة
                    </button>
                </form>

                <p style="color: #991B1B; font-size: 12px; margin: 12px 0 0;">
                    ⚠️ لا يمكن حذف خطة فيها دفعات مدفوعة.
                </p>
            </div>
        </div>

    </div>

</div>

{{-- Modal للدفع --}}
<div id="paymentModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; padding: 32px; border-radius: 16px; max-width: 500px; width: 90%;">
        <h3 style="margin: 0 0 20px; font-size: 20px; font-weight: 900;">✅ تسجيل دفع القسط</h3>
        
        <form id="paymentForm" method="POST">
            @csrf
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-weight: 700; margin-bottom: 8px;">طريقة الدفع</label>
                <select name="payment_method" required style="width: 100%; padding: 10px; border: 1px solid #E2E8F0; border-radius: 8px; font-family: inherit;">
                    <option value="نقدي">نقدي</option>
                    <option value="بطاقة">بطاقة</option>
                    <option value="تحويل بنكي">تحويل بنكي</option>
                    <option value="شيك">شيك</option>
                </select>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-weight: 700; margin-bottom: 8px;">تاريخ الدفع</label>
                <input type="date" name="paid_date" value="{{ date('Y-m-d') }}" required style="width: 100%; padding: 10px; border: 1px solid #E2E8F0; border-radius: 8px; font-family: inherit;">
            </div>

            <div style="display: flex; gap: 12px;">
                <button type="button" onclick="closePaymentModal()" style="flex: 1; background: #F1F5F9; color: #475569; padding: 12px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer;">إلغاء</button>
                <button type="submit" style="flex: 1; background: #10B981; color: white; padding: 12px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer;">تأكيد الدفع</button>
            </div>
        </form>
    </div>
</div>

<script>
function showPaymentModal(paymentId) {
    const modal = document.getElementById('paymentModal');
    const form = document.getElementById('paymentForm');
    form.action = `/user/installment/mark-as-paid/${paymentId}`;
    modal.style.display = 'flex';
}

function closePaymentModal() {
    document.getElementById('paymentModal').style.display = 'none';
}

// إغلاق عند الضغط خارج الـmodal
document.getElementById('paymentModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closePaymentModal();
    }
});
</script>

@endsection