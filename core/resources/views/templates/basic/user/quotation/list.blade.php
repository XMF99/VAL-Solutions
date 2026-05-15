@extends($activeTemplate . 'layouts.master')

@section('panel')
<div style="padding: 20px; font-family: 'Cairo','Tajawal',sans-serif; direction: rtl;">

    {{-- ═══════ Header ═══════ --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 28px; font-weight: 900; margin: 0; color: #0F172A;">
                📋 عروض الأسعار
            </h1>
            <p style="color: #64748B; margin: 4px 0 0;">إدارة عروض أسعار العملاء</p>
        </div>
        <a href="{{ route('user.quotation.create') }}"
           style="background: linear-gradient(135deg, #4F46E5, #7C3AED); color: white; padding: 12px 24px; border-radius: 10px; text-decoration: none; font-weight: 700; box-shadow: 0 4px 12px rgba(79,70,229,0.3);">
            ➕ عرض سعر جديد
        </a>
    </div>

    {{-- ═══════ Stats Cards ═══════ --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">

        <div style="background: white; padding: 20px; border-radius: 16px; border: 1px solid #E2E8F0;">
            <div style="color: #64748B; font-size: 13px; margin-bottom: 8px;">📊 إجمالي العروض</div>
            <div style="font-size: 28px; font-weight: 900; color: #0F172A;">{{ $stats['total'] }}</div>
        </div>

        <div style="background: white; padding: 20px; border-radius: 16px; border: 1px solid #E2E8F0;">
            <div style="color: #64748B; font-size: 13px; margin-bottom: 8px;">📝 مسودّات</div>
            <div style="font-size: 28px; font-weight: 900; color: #6B7280;">{{ $stats['draft'] }}</div>
        </div>

        <div style="background: white; padding: 20px; border-radius: 16px; border: 1px solid #E2E8F0;">
            <div style="color: #64748B; font-size: 13px; margin-bottom: 8px;">📤 مرسلة</div>
            <div style="font-size: 28px; font-weight: 900; color: #0EA5E9;">{{ $stats['sent'] }}</div>
        </div>

        <div style="background: white; padding: 20px; border-radius: 16px; border: 1px solid #E2E8F0;">
            <div style="color: #64748B; font-size: 13px; margin-bottom: 8px;">✅ مقبولة</div>
            <div style="font-size: 28px; font-weight: 900; color: #10B981;">{{ $stats['accepted'] }}</div>
        </div>

    </div>

    {{-- ═══════ Search & Filter ═══════ --}}
    <div style="background: white; padding: 16px; border-radius: 12px; margin-bottom: 16px; border: 1px solid #E2E8F0;">
        <form method="GET" action="{{ route('user.quotation.list') }}" style="display: flex; gap: 12px; flex-wrap: wrap;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 ابحث برقم العرض أو اسم العميل..."
                   style="flex: 1; min-width: 250px; padding: 10px 16px; border: 1px solid #E2E8F0; border-radius: 8px; font-family: inherit;">

            <select name="status" style="padding: 10px 16px; border: 1px solid #E2E8F0; border-radius: 8px; font-family: inherit; min-width: 150px;">
                <option value="all">كل الحالات</option>
                <option value="0" @selected(request('status') === '0')>📝 مسودّة</option>
                <option value="1" @selected(request('status') === '1')>📤 مُرسلة</option>
                <option value="2" @selected(request('status') === '2')>✅ مقبولة</option>
                <option value="3" @selected(request('status') === '3')>❌ مرفوضة</option>
                <option value="4" @selected(request('status') === '4')>⏰ منتهية</option>
            </select>

            <button type="submit"
                    style="background: #4F46E5; color: white; padding: 10px 24px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer;">
                بحث
            </button>
        </form>
    </div>

    {{-- ═══════ Quotations Table ═══════ --}}
    <div style="background: white; border-radius: 16px; border: 1px solid #E2E8F0; overflow: hidden;">

        @if($quotations->count() > 0)
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: #F8FAFC;">
                    <tr>
                        <th style="padding: 14px 16px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">رقم العرض</th>
                        <th style="padding: 14px 16px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">العميل</th>
                        <th style="padding: 14px 16px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">التاريخ</th>
                        <th style="padding: 14px 16px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">صالح حتى</th>
                        <th style="padding: 14px 16px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">المبلغ</th>
                        <th style="padding: 14px 16px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">الحالة</th>
                        <th style="padding: 14px 16px; text-align: center; font-size: 13px; font-weight: 700; color: #64748B;">إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quotations as $q)
                    <tr style="border-top: 1px solid #F1F5F9;">
                        <td style="padding: 14px 16px; font-weight: 700; color: #4F46E5;">{{ $q->quotation_no }}</td>
                        <td style="padding: 14px 16px;">{{ $q->customer->name ?? '-' }}</td>
                        <td style="padding: 14px 16px; color: #64748B;">{{ $q->quotation_date?->format('Y-m-d') ?? '-' }}</td>
                        <td style="padding: 14px 16px; color: #64748B;">{{ $q->valid_until?->format('Y-m-d') ?? '-' }}</td>
                        <td style="padding: 14px 16px; font-weight: 700;">{{ number_format($q->total, 2) }}</td>
                        <td style="padding: 14px 16px;">
                            <span style="background: {{ $q->status_color === 'success' ? '#D1FAE5' : ($q->status_color === 'danger' ? '#FEE2E2' : ($q->status_color === 'info' ? '#DBEAFE' : ($q->status_color === 'warning' ? '#FEF3C7' : '#F3F4F6'))) }};
                                         color: {{ $q->status_color === 'success' ? '#065F46' : ($q->status_color === 'danger' ? '#991B1B' : ($q->status_color === 'info' ? '#1E40AF' : ($q->status_color === 'warning' ? '#92400E' : '#374151'))) }};
                                         padding: 4px 12px; border-radius: 999px; font-size: 12px; font-weight: 700;">
                                {{ $q->status_name }}
                            </span>
                        </td>
                        <td style="padding: 14px 16px; text-align: center;">
                            <a href="{{ route('user.quotation.show', $q->id) }}"
                               style="background: #EEF2FF; color: #4F46E5; padding: 6px 12px; border-radius: 8px; text-decoration: none; font-size: 13px; margin: 0 2px;">👁️ عرض</a>
                            <a href="{{ route('user.quotation.edit', $q->id) }}"
                               style="background: #FEF3C7; color: #92400E; padding: 6px 12px; border-radius: 8px; text-decoration: none; font-size: 13px; margin: 0 2px;">✏️ تعديل</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- ═══════ Pagination ═══════ --}}
            <div style="padding: 16px;">
                {{ $quotations->withQueryString()->links() }}
            </div>

        @else
            {{-- ═══════ Empty State ═══════ --}}
            <div style="padding: 60px 20px; text-align: center;">
                <div style="font-size: 64px; margin-bottom: 16px;">📋</div>
                <h3 style="color: #0F172A; margin: 0 0 8px;">لا توجد عروض أسعار بعد</h3>
                <p style="color: #64748B; margin: 0 0 24px;">ابدأ بإنشاء أوّل عرض سعر للعملاء</p>
                <a href="{{ route('user.quotation.create') }}"
                   style="background: #4F46E5; color: white; padding: 12px 28px; border-radius: 10px; text-decoration: none; font-weight: 700;">
                    ➕ إنشاء عرض سعر
                </a>
            </div>
        @endif

    </div>

</div>
@endsection