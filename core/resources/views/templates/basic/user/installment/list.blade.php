@extends($activeTemplate . 'layouts.master')

@section('panel')
<div style="padding: 20px; font-family: 'Cairo','Tajawal',sans-serif; direction: rtl;">

    {{-- ═══════ Header ═══════ --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 28px; font-weight: 900; margin: 0; color: #0F172A;">
                💳 خطط التقسيط
            </h1>
            <p style="color: #64748B; margin: 4px 0 0;">إدارة خطط التقسيط والدفعات</p>
        </div>
        <a href="{{ route('user.installment.create') }}"
           style="background: linear-gradient(135deg, #10B981, #059669); color: white; padding: 12px 24px; border-radius: 10px; text-decoration: none; font-weight: 700; box-shadow: 0 4px 12px rgba(16,185,129,0.3);">
            ➕ خطة تقسيط جديدة
        </a>
    </div>

    {{-- ═══════ Stats Cards ═══════ --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">

        <div style="background: white; padding: 20px; border-radius: 16px; border: 1px solid #E2E8F0;">
            <div style="color: #64748B; font-size: 13px; margin-bottom: 8px;">📊 إجمالي الخطط</div>
            <div style="font-size: 28px; font-weight: 900; color: #0F172A;">{{ $stats['total'] }}</div>
        </div>

        <div style="background: white; padding: 20px; border-radius: 16px; border: 1px solid #E2E8F0;">
            <div style="color: #64748B; font-size: 13px; margin-bottom: 8px;">✅ نشطة</div>
            <div style="font-size: 28px; font-weight: 900; color: #10B981;">{{ $stats['active'] }}</div>
        </div>

        <div style="background: white; padding: 20px; border-radius: 16px; border: 1px solid #E2E8F0;">
            <div style="color: #64748B; font-size: 13px; margin-bottom: 8px;">⚠️ دفعات متأخرة</div>
            <div style="font-size: 28px; font-weight: 900; color: #EF4444;">{{ $stats['overdue'] }}</div>
        </div>

    </div>

    {{-- ═══════ Search & Filter ═══════ --}}
    <div style="background: white; padding: 16px; border-radius: 12px; margin-bottom: 16px; border: 1px solid #E2E8F0;">
        <form method="GET" action="{{ route('user.installment.list') }}" style="display: flex; gap: 12px; flex-wrap: wrap;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 ابحث برقم الفاتورة..."
                   style="flex: 1; min-width: 250px; padding: 10px 16px; border: 1px solid #E2E8F0; border-radius: 8px; font-family: inherit;">

            <select name="status" style="padding: 10px 16px; border: 1px solid #E2E8F0; border-radius: 8px; font-family: inherit; min-width: 150px;">
                <option value="">كل الخطط</option>
                <option value="active" @selected(request('status') === 'active')>✅ نشطة</option>
                <option value="completed" @selected(request('status') === 'completed')>🎉 مكتملة</option>
            </select>

            <button type="submit"
                    style="background: #10B981; color: white; padding: 10px 24px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer;">
                بحث
            </button>
        </form>
    </div>

    {{-- ═══════ Installment Plans Table ═══════ --}}
    <div style="background: white; border-radius: 16px; border: 1px solid #E2E8F0; overflow: hidden;">

        @if($plans->count() > 0)
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: #F8FAFC;">
                    <tr>
                        <th style="padding: 14px 16px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">الفاتورة</th>
                        <th style="padding: 14px 16px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">العميل</th>
                        <th style="padding: 14px 16px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">المبلغ الكلي</th>
                        <th style="padding: 14px 16px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">عدد الأقساط</th>
                        <th style="padding: 14px 16px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">المدفوع</th>
                        <th style="padding: 14px 16px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">المتبقي</th>
                        <th style="padding: 14px 16px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">التقدّم</th>
                        <th style="padding: 14px 16px; text-align: center; font-size: 13px; font-weight: 700; color: #64748B;">إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($plans as $plan)
                    <tr style="border-top: 1px solid #F1F5F9;">
                        <td style="padding: 14px 16px; font-weight: 700; color: #4F46E5;">{{ $plan->sale->invoice_no ?? '-' }}</td>
                        <td style="padding: 14px 16px;">{{ $plan->sale->customer->name ?? '-' }}</td>
                        <td style="padding: 14px 16px; font-weight: 700;">{{ number_format($plan->total_amount, 2) }}</td>
                        <td style="padding: 14px 16px;">{{ $plan->number_of_installments }}</td>
                        <td style="padding: 14px 16px; color: #10B981; font-weight: 700;">{{ number_format($plan->paid_amount, 2) }}</td>
                        <td style="padding: 14px 16px; color: #EF4444; font-weight: 700;">{{ number_format($plan->remaining_amount, 2) }}</td>
                        <td style="padding: 14px 16px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="flex: 1; height: 8px; background: #F1F5F9; border-radius: 999px; overflow: hidden;">
                                    <div style="height: 100%; background: linear-gradient(90deg, #10B981, #059669); width: {{ $plan->completion_percentage }}%; transition: width 0.3s;"></div>
                                </div>
                                <span style="font-size: 12px; font-weight: 700; color: #64748B;">{{ $plan->completion_percentage }}%</span>
                            </div>
                        </td>
                        <td style="padding: 14px 16px; text-align: center;">
                            <a href="{{ route('user.installment.show', $plan->id) }}"
                               style="background: #EEF2FF; color: #4F46E5; padding: 6px 12px; border-radius: 8px; text-decoration: none; font-size: 13px;">👁️ عرض</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- ═══════ Pagination ═══════ --}}
            <div style="padding: 16px;">
                {{ $plans->withQueryString()->links() }}
            </div>

        @else
            {{-- ═══════ Empty State ═══════ --}}
            <div style="padding: 60px 20px; text-align: center;">
                <div style="font-size: 64px; margin-bottom: 16px;">💳</div>
                <h3 style="color: #0F172A; margin: 0 0 8px;">لا توجد خطط تقسيط بعد</h3>
                <p style="color: #64748B; margin: 0 0 24px;">ابدأ بإنشاء خطة تقسيط لفاتورة</p>
                <a href="{{ route('user.installment.create') }}"
                   style="background: #10B981; color: white; padding: 12px 28px; border-radius: 10px; text-decoration: none; font-weight: 700;">
                    ➕ إنشاء خطة تقسيط
                </a>
            </div>
        @endif

    </div>

</div>
@endsection