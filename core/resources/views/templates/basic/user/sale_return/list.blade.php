@extends($activeTemplate . 'layouts.master')

@section('panel')
<div style="padding: 20px; font-family: 'Cairo','Tajawal',sans-serif; direction: rtl;">

    {{-- ═══════ Header ═══════ --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 28px; font-weight: 900; margin: 0; color: #0F172A;">
                ↩️ مرتجعات المبيعات
            </h1>
            <p style="color: #64748B; margin: 4px 0 0;">إدارة المرتجعات واسترداد المبالغ</p>
        </div>
        <a href="{{ route('user.sale_return.create') }}"
           style="background: linear-gradient(135deg, #EF4444, #DC2626); color: white; padding: 12px 24px; border-radius: 10px; text-decoration: none; font-weight: 700; box-shadow: 0 4px 12px rgba(239,68,68,0.3);">
            ➕ مرتجع جديد
        </a>
    </div>

    {{-- ═══════ Stats Cards ═══════ --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">

        <div style="background: white; padding: 20px; border-radius: 16px; border: 1px solid #E2E8F0;">
            <div style="color: #64748B; font-size: 13px; margin-bottom: 8px;">📊 إجمالي المرتجعات</div>
            <div style="font-size: 28px; font-weight: 900; color: #0F172A;">{{ $stats['total'] }}</div>
        </div>

        <div style="background: white; padding: 20px; border-radius: 16px; border: 1px solid #E2E8F0;">
            <div style="color: #64748B; font-size: 13px; margin-bottom: 8px;">⏳ معلّقة</div>
            <div style="font-size: 28px; font-weight: 900; color: #F59E0B;">{{ $stats['pending'] }}</div>
        </div>

        <div style="background: white; padding: 20px; border-radius: 16px; border: 1px solid #E2E8F0;">
            <div style="color: #64748B; font-size: 13px; margin-bottom: 8px;">✅ معتمدة</div>
            <div style="font-size: 28px; font-weight: 900; color: #0EA5E9;">{{ $stats['approved'] }}</div>
        </div>

        <div style="background: white; padding: 20px; border-radius: 16px; border: 1px solid #E2E8F0;">
            <div style="color: #64748B; font-size: 13px; margin-bottom: 8px;">🎉 مكتملة</div>
            <div style="font-size: 28px; font-weight: 900; color: #10B981;">{{ $stats['completed'] }}</div>
        </div>

    </div>

    {{-- ═══════ Search & Filter ═══════ --}}
    <div style="background: white; padding: 16px; border-radius: 12px; margin-bottom: 16px; border: 1px solid #E2E8F0;">
        <form method="GET" action="{{ route('user.sale_return.list') }}" style="display: flex; gap: 12px; flex-wrap: wrap;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 ابحث برقم المرتجع أو الفاتورة..."
                   style="flex: 1; min-width: 250px; padding: 10px 16px; border: 1px solid #E2E8F0; border-radius: 8px; font-family: inherit;">

            <select name="status" style="padding: 10px 16px; border: 1px solid #E2E8F0; border-radius: 8px; font-family: inherit; min-width: 150px;">
                <option value="all">كل الحالات</option>
                <option value="0" @selected(request('status') === '0')>⏳ معلّقة</option>
                <option value="1" @selected(request('status') === '1')>✅ معتمدة</option>
                <option value="2" @selected(request('status') === '2')>❌ مرفوضة</option>
                <option value="3" @selected(request('status') === '3')>🎉 مكتملة</option>
            </select>

            <button type="submit"
                    style="background: #EF4444; color: white; padding: 10px 24px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer;">
                بحث
            </button>
        </form>
    </div>

    {{-- ═══════ Returns Table ═══════ --}}
    <div style="background: white; border-radius: 16px; border: 1px solid #E2E8F0; overflow: hidden;">

        @if($returns->count() > 0)
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: #F8FAFC;">
                    <tr>
                        <th style="padding: 14px 16px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">رقم المرتجع</th>
                        <th style="padding: 14px 16px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">الفاتورة</th>
                        <th style="padding: 14px 16px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">العميل</th>
                        <th style="padding: 14px 16px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">التاريخ</th>
                        <th style="padding: 14px 16px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">المبلغ</th>
                        <th style="padding: 14px 16px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">طريقة الرد</th>
                        <th style="padding: 14px 16px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">الحالة</th>
                        <th style="padding: 14px 16px; text-align: center; font-size: 13px; font-weight: 700; color: #64748B;">إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($returns as $return)
                    <tr style="border-top: 1px solid #F1F5F9;">
                        <td style="padding: 14px 16px; font-weight: 700; color: #EF4444;">{{ $return->return_no }}</td>
                        <td style="padding: 14px 16px; color: #4F46E5;">{{ $return->sale->invoice_no ?? '-' }}</td>
                        <td style="padding: 14px 16px;">{{ $return->sale->customer->name ?? '-' }}</td>
                        <td style="padding: 14px 16px; color: #64748B;">{{ $return->return_date?->format('Y-m-d') ?? '-' }}</td>
                        <td style="padding: 14px 16px; font-weight: 700;">{{ number_format($return->total, 2) }}</td>
                        <td style="padding: 14px 16px;">{{ $return->refund_method_name }}</td>
                        <td style="padding: 14px 16px;">
                            <span style="background: {{ $return->status_color === 'success' ? '#D1FAE5' : ($return->status_color === 'danger' ? '#FEE2E2' : ($return->status_color === 'info' ? '#DBEAFE' : ($return->status_color === 'warning' ? '#FEF3C7' : '#F3F4F6'))) }};
                                         color: {{ $return->status_color === 'success' ? '#065F46' : ($return->status_color === 'danger' ? '#991B1B' : ($return->status_color === 'info' ? '#1E40AF' : ($return->status_color === 'warning' ? '#92400E' : '#374151'))) }};
                                         padding: 4px 12px; border-radius: 999px; font-size: 12px; font-weight: 700;">
                                {{ $return->status_name }}
                            </span>
                        </td>
                        <td style="padding: 14px 16px; text-align: center;">
                            <a href="{{ route('user.sale_return.show', $return->id) }}"
                               style="background: #EEF2FF; color: #4F46E5; padding: 6px 12px; border-radius: 8px; text-decoration: none; font-size: 13px;">👁️ عرض</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- ═══════ Pagination ═══════ --}}
            <div style="padding: 16px;">
                {{ $returns->withQueryString()->links() }}
            </div>

        @else
            {{-- ═══════ Empty State ═══════ --}}
            <div style="padding: 60px 20px; text-align: center;">
                <div style="font-size: 64px; margin-bottom: 16px;">↩️</div>
                <h3 style="color: #0F172A; margin: 0 0 8px;">لا توجد مرتجعات بعد</h3>
                <p style="color: #64748B; margin: 0 0 24px;">عند إرجاع منتج من فاتورة، سيظهر هنا</p>
                <a href="{{ route('user.sale_return.create') }}"
                   style="background: #EF4444; color: white; padding: 12px 28px; border-radius: 10px; text-decoration: none; font-weight: 700;">
                    ➕ إنشاء مرتجع
                </a>
            </div>
        @endif

    </div>

</div>
@endsection