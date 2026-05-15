@extends($activeTemplate . 'layouts.master')

@section('panel')
<div style="padding: 20px; font-family: 'Cairo','Tajawal',sans-serif; direction: rtl;">

    {{-- ═══════ Header ═══════ --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 28px; font-weight: 900; margin: 0; color: #0F172A;">
                مرتجع رقم: <span style="color: #EF4444;">{{ $saleReturn->return_no }}</span>
            </h1>
            <p style="color: #64748B; margin: 4px 0 0;">تفاصيل المرتجع وإجراءاته</p>
        </div>
        <a href="{{ route('user.sale_return.list') }}"
           style="background: #F1F5F9; color: #475569; padding: 10px 20px; border-radius: 10px; text-decoration: none; font-weight: 700;">
            ← رجوع للقائمة
        </a>
    </div>

    {{-- ═══════ Status Badge ═══════ --}}
    <div style="margin-bottom: 24px;">
        <span style="background: {{ $saleReturn->status_color === 'success' ? '#D1FAE5' : ($saleReturn->status_color === 'danger' ? '#FEE2E2' : ($saleReturn->status_color === 'info' ? '#DBEAFE' : ($saleReturn->status_color === 'warning' ? '#FEF3C7' : '#F3F4F6'))) }};
                     color: {{ $saleReturn->status_color === 'success' ? '#065F46' : ($saleReturn->status_color === 'danger' ? '#991B1B' : ($saleReturn->status_color === 'info' ? '#1E40AF' : ($saleReturn->status_color === 'warning' ? '#92400E' : '#374151'))) }};
                     padding: 8px 20px; border-radius: 999px; font-size: 16px; font-weight: 700; display: inline-block;">
            {{ $saleReturn->status_name }}
        </span>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">

        {{-- ═══════ معلومات المرتجع ═══════ --}}
        <div style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #E2E8F0;">
            <h3 style="font-size: 18px; font-weight: 700; margin: 0 0 20px; color: #0F172A; border-bottom: 2px solid #EF4444; padding-bottom: 12px;">
                📋 معلومات المرتجع
            </h3>
            
            <div style="display: grid; gap: 14px;">
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #F1F5F9;">
                    <span style="color: #64748B;">رقم المرتجع:</span>
                    <span style="font-weight: 700; color: #EF4444;">{{ $saleReturn->return_no }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #F1F5F9;">
                    <span style="color: #64748B;">التاريخ:</span>
                    <span style="font-weight: 700;">{{ $saleReturn->return_date?->format('Y-m-d') ?? '-' }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #F1F5F9;">
                    <span style="color: #64748B;">طريقة الرد:</span>
                    <span style="font-weight: 700;">{{ $saleReturn->refund_method_name }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #F1F5F9;">
                    <span style="color: #64748B;">الحالة:</span>
                    <span style="font-weight: 700;">{{ $saleReturn->status_name }}</span>
                </div>
            </div>
        </div>

        {{-- ═══════ الفاتورة الأصلية ═══════ --}}
        <div style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #E2E8F0;">
            <h3 style="font-size: 18px; font-weight: 700; margin: 0 0 20px; color: #0F172A; border-bottom: 2px solid #4F46E5; padding-bottom: 12px;">
                📄 الفاتورة الأصلية
            </h3>
            
            <div style="display: grid; gap: 14px;">
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #F1F5F9;">
                    <span style="color: #64748B;">رقم الفاتورة:</span>
                    <span style="font-weight: 700; color: #4F46E5;">{{ $saleReturn->sale->invoice_no ?? '-' }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #F1F5F9;">
                    <span style="color: #64748B;">العميل:</span>
                    <span style="font-weight: 700;">{{ $saleReturn->sale->customer->name ?? '-' }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #F1F5F9;">
                    <span style="color: #64748B;">تاريخ الفاتورة:</span>
                    <span style="font-weight: 700;">{{ $saleReturn->sale->created_at?->format('Y-m-d') ?? '-' }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #F1F5F9;">
                    <span style="color: #64748B;">إجمالي الفاتورة:</span>
                    <span style="font-weight: 700; color: #10B981; font-size: 18px;">{{ number_format($saleReturn->sale->total ?? 0, 2) }}</span>
                </div>
            </div>
        </div>

    </div>

    {{-- ═══════ سبب الإرجاع (إذا وُجِد) ═══════ --}}
    @if($saleReturn->return_reason)
    <div style="background: #FEF3C7; padding: 16px; border-radius: 12px; border: 1px solid #FDE68A; margin-bottom: 24px;">
        <div style="font-weight: 700; color: #92400E; margin-bottom: 8px;">💬 سبب الإرجاع:</div>
        <div style="color: #78350F;">{{ $saleReturn->return_reason }}</div>
    </div>
    @endif

    {{-- ═══════ البنود المرتجعة ═══════ --}}
    <div style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #E2E8F0; margin-bottom: 24px;">
        <h3 style="font-size: 18px; font-weight: 700; margin: 0 0 20px; color: #0F172A;">🛒 البنود المرتجعة</h3>

        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #F8FAFC;">
                <tr>
                    <th style="padding: 12px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B; border-bottom: 2px solid #E2E8F0;">المنتج</th>
                    <th style="padding: 12px; text-align: center; font-size: 13px; font-weight: 700; color: #64748B; border-bottom: 2px solid #E2E8F0;">الكمية</th>
                    <th style="padding: 12px; text-align: center; font-size: 13px; font-weight: 700; color: #64748B; border-bottom: 2px solid #E2E8F0;">السعر</th>
                    <th style="padding: 12px; text-align: center; font-size: 13px; font-weight: 700; color: #64748B; border-bottom: 2px solid #E2E8F0;">الضريبة</th>
                    <th style="padding: 12px; text-align: center; font-size: 13px; font-weight: 700; color: #64748B; border-bottom: 2px solid #E2E8F0;">المجموع</th>
                </tr>
            </thead>
            <tbody>
                @foreach($saleReturn->items as $item)
                <tr style="border-bottom: 1px solid #F1F5F9;">
                    <td style="padding: 14px;">
                        <div style="font-weight: 700; color: #0F172A;">{{ $item->product_name }}</div>
                        @if($item->return_reason)
                            <div style="font-size: 12px; color: #64748B; margin-top: 4px;">💬 {{ $item->return_reason }}</div>
                        @endif
                    </td>
                    <td style="padding: 14px; text-align: center; font-weight: 700;">{{ $item->quantity }}</td>
                    <td style="padding: 14px; text-align: center;">{{ number_format($item->unit_price, 2) }}</td>
                    <td style="padding: 14px; text-align: center;">{{ $item->tax_rate }}%</td>
                    <td style="padding: 14px; text-align: center; font-weight: 700; color: #EF4444;">{{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- ═══════ ملخص المبالغ ═══════ --}}
    <div style="background: linear-gradient(135deg, #FEE2E2, #FECACA); padding: 24px; border-radius: 16px; margin-bottom: 24px;">
        <div style="max-width: 400px; margin-right: auto;">
            <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid rgba(239,68,68,0.2);">
                <span style="color: #7F1D1D;">المجموع الفرعي:</span>
                <span style="font-weight: 700; color: #991B1B;">{{ number_format($saleReturn->subtotal, 2) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid rgba(239,68,68,0.2);">
                <span style="color: #7F1D1D;">الخصم:</span>
                <span style="font-weight: 700; color: #991B1B;">{{ number_format($saleReturn->discount, 2) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid rgba(239,68,68,0.2);">
                <span style="color: #7F1D1D;">الضريبة:</span>
                <span style="font-weight: 700; color: #991B1B;">{{ number_format($saleReturn->tax, 2) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 14px 0; border-top: 2px solid #B91C1C;">
                <span style="font-size: 18px; font-weight: 900; color: #450A0A;">الإجمالي:</span>
                <span style="font-size: 24px; font-weight: 900; color: #7F1D1D;">{{ number_format($saleReturn->total, 2) }} ريال</span>
            </div>
        </div>
    </div>

    {{-- ═══════ الإجراءات ═══════ --}}
    <div style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #E2E8F0;">
        <h3 style="font-size: 18px; font-weight: 700; margin: 0 0 20px; color: #0F172A;">⚡ الإجراءات</h3>

        <div style="display: flex; gap: 12px; flex-wrap: wrap;">

            @if($saleReturn->status === 0)
                {{-- معلّق → يمكن الاعتماد أو الرفض --}}
                <form action="{{ route('user.sale_return.approve', $saleReturn->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" onclick="return confirm('هل تريد اعتماد هذا المرتجع؟')"
                            style="background: #0EA5E9; color: white; padding: 12px 24px; border: none; border-radius: 10px; font-weight: 700; cursor: pointer;">
                        ✅ اعتماد المرتجع
                    </button>
                </form>

                <form action="{{ route('user.sale_return.reject', $saleReturn->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" onclick="return confirm('هل تريد رفض هذا المرتجع؟')"
                            style="background: #EF4444; color: white; padding: 12px 24px; border: none; border-radius: 10px; font-weight: 700; cursor: pointer;">
                        ❌ رفض المرتجع
                    </button>
                </form>
            @endif

            @if($saleReturn->status === 1)
                {{-- معتمد → يمكن الإكمال --}}
                <form action="{{ route('user.sale_return.complete', $saleReturn->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" onclick="return confirm('سيتم رد المبلغ وإرجاع المنتجات للمخزون. هل تريد المتابعة؟')"
                            style="background: #10B981; color: white; padding: 12px 24px; border: none; border-radius: 10px; font-weight: 700; cursor: pointer;">
                        🎉 إكمال المرتجع
                    </button>
                </form>
            @endif

            @if(in_array($saleReturn->status, [0, 2]))
                {{-- يمكن حذف المعلّق أو المرفوض --}}
                <form action="{{ route('user.sale_return.delete', $saleReturn->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" onclick="return confirm('هل تريد حذف هذا المرتجع نهائياً؟')"
                            style="background: #F87171; color: white; padding: 12px 24px; border: none; border-radius: 10px; font-weight: 700; cursor: pointer;">
                        🗑️ حذف المرتجع
                    </button>
                </form>
            @endif

        </div>
    </div>

</div>
@endsection