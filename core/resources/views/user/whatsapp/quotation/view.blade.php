@extends($activeTemplate . 'layouts.master')

@section('panel')
<div style="padding: 20px; font-family: 'Cairo','Tajawal',sans-serif; direction: rtl;">

    {{-- ═══════ Header with Actions ═══════ --}}
    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 28px; font-weight: 900; margin: 0; color: #0F172A;">
                📋 عرض سعر رقم: {{ $quotation->quotation_no }}
            </h1>
            <p style="color: #64748B; margin: 4px 0 0;">تفاصيل عرض السعر للعميل {{ $quotation->customer->name ?? '-' }}</p>
        </div>

        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
            <a href="{{ route('user.quotation.edit', $quotation->id) }}"
               style="background: #FEF3C7; color: #92400E; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 14px;">
                ✏️ تعديل
            </a>
            <a href="{{ route('user.quotation.print', $quotation->id) }}" target="_blank"
               style="background: #DBEAFE; color: #1E40AF; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 14px;">
                🖨️ طباعة
            </a>
            <form action="{{ route('user.quotation.duplicate', $quotation->id) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit"
                        style="background: #E0E7FF; color: #4F46E5; padding: 10px 20px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 14px;">
                    📑 تكرار
                </button>
            </form>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px;">

        {{-- ═══════ Left: Main Details ═══════ --}}
        <div>
            {{-- Card 1: Basic Info --}}
            <div style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #E2E8F0; margin-bottom: 20px;">
                <h3 style="font-size: 18px; font-weight: 700; margin: 0 0 20px; color: #0F172A;">📄 المعلومات الأساسيّة</h3>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div>
                        <div style="color: #64748B; font-size: 13px; margin-bottom: 4px;">رقم العرض</div>
                        <div style="font-weight: 700; color: #4F46E5;">{{ $quotation->quotation_no }}</div>
                    </div>
                    <div>
                        <div style="color: #64748B; font-size: 13px; margin-bottom: 4px;">العميل</div>
                        <div style="font-weight: 700;">{{ $quotation->customer->name ?? '-' }}</div>
                    </div>
                    <div>
                        <div style="color: #64748B; font-size: 13px; margin-bottom: 4px;">تاريخ العرض</div>
                        <div style="font-weight: 700;">{{ $quotation->quotation_date?->format('Y-m-d') ?? '-' }}</div>
                    </div>
                    <div>
                        <div style="color: #64748B; font-size: 13px; margin-bottom: 4px;">صالح حتى</div>
                        <div style="font-weight: 700;">{{ $quotation->valid_until?->format('Y-m-d') ?? '-' }}</div>
                    </div>
                </div>
            </div>

            {{-- Card 2: Items --}}
            <div style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #E2E8F0;">
                <h3 style="font-size: 18px; font-weight: 700; margin: 0 0 16px; color: #0F172A;">🛒 البنود</h3>

                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead style="background: #F8FAFC;">
                            <tr>
                                <th style="padding: 12px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">المنتج</th>
                                <th style="padding: 12px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">الكميّة</th>
                                <th style="padding: 12px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">السعر</th>
                                <th style="padding: 12px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">الخصم</th>
                                <th style="padding: 12px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">الضريبة</th>
                                <th style="padding: 12px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">المجموع</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quotation->items as $item)
                            <tr style="border-top: 1px solid #F1F5F9;">
                                <td style="padding: 12px;">
                                    <div style="font-weight: 700;">{{ $item->product_name }}</div>
                                    @if($item->description)
                                        <div style="font-size: 12px; color: #64748B; margin-top: 2px;">{{ $item->description }}</div>
                                    @endif
                                </td>
                                <td style="padding: 12px;">{{ $item->quantity }}</td>
                                <td style="padding: 12px;">{{ number_format($item->unit_price, 2) }}</td>
                                <td style="padding: 12px; color: #EF4444;">{{ $item->discount }}%</td>
                                <td style="padding: 12px; color: #10B981;">{{ $item->tax_rate }}%</td>
                                <td style="padding: 12px; font-weight: 700;">{{ number_format($item->total, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Totals Summary --}}
                <div style="margin-top: 20px; padding: 16px; background: #F8FAFC; border-radius: 12px; max-width: 350px; margin-left: auto;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span style="color: #64748B;">المجموع الفرعي:</span>
                        <span style="font-weight: 700;">{{ number_format($quotation->subtotal, 2) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span style="color: #64748B;">الخصم:</span>
                        <span style="font-weight: 700; color: #EF4444;">{{ number_format($quotation->discount, 2) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span style="color: #64748B;">الضريبة:</span>
                        <span style="font-weight: 700; color: #10B981;">{{ number_format($quotation->tax, 2) }}</span>
                    </div>
                    <div style="border-top: 2px solid #E2E8F0; padding-top: 8px; margin-top: 8px;">
                        <div style="display: flex; justify-content: space-between;">
                            <span style="font-weight: 900; font-size: 18px;">الإجمالي:</span>
                            <span style="font-weight: 900; font-size: 18px; color: #4F46E5;">{{ number_format($quotation->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 3: Notes --}}
            @if($quotation->notes)
            <div style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #E2E8F0; margin-top: 20px;">
                <h3 style="font-size: 18px; font-weight: 700; margin: 0 0 12px; color: #0F172A;">📝 ملاحظات</h3>
                <p style="color: #334155; line-height: 1.6; margin: 0;">{{ $quotation->notes }}</p>
            </div>
            @endif
        </div>

        {{-- ═══════ Right: Status & Actions ═══════ --}}
        <div>
            {{-- Status Card --}}
            <div style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #E2E8F0; margin-bottom: 20px;">
                <h3 style="font-size: 18px; font-weight: 700; margin: 0 0 16px; color: #0F172A;">📊 الحالة</h3>

                <div style="text-align: center; margin-bottom: 20px;">
                    <span style="background: {{ $quotation->status_color === 'success' ? '#D1FAE5' : ($quotation->status_color === 'danger' ? '#FEE2E2' : ($quotation->status_color === 'info' ? '#DBEAFE' : ($quotation->status_color === 'warning' ? '#FEF3C7' : '#F3F4F6'))) }};
                                 color: {{ $quotation->status_color === 'success' ? '#065F46' : ($quotation->status_color === 'danger' ? '#991B1B' : ($quotation->status_color === 'info' ? '#1E40AF' : ($quotation->status_color === 'warning' ? '#92400E' : '#374151'))) }};
                                 padding: 8px 20px; border-radius: 999px; font-size: 16px; font-weight: 900; display: inline-block;">
                        {{ $quotation->status_name }}
                    </span>
                </div>

                <div style="margin-top: 20px;">
                    <label style="display: block; font-weight: 700; margin-bottom: 8px; color: #334155;">تغيير الحالة</label>
                    <form action="{{ route('user.quotation.status.change', $quotation->id) }}" method="POST">
                        @csrf
                        <select name="status" onchange="this.form.submit()"
                                style="width: 100%; padding: 10px; border: 1px solid #E2E8F0; border-radius: 8px; font-family: inherit; margin-bottom: 8px;">
                            <option value="0" @selected($quotation->quotation_status == 0)>📝 مسودّة</option>
                            <option value="1" @selected($quotation->quotation_status == 1)>📤 مُرسلة</option>
                            <option value="2" @selected($quotation->quotation_status == 2)>✅ مقبولة</option>
                            <option value="3" @selected($quotation->quotation_status == 3)>❌ مرفوضة</option>
                            <option value="4" @selected($quotation->quotation_status == 4)>⏰ منتهية</option>
                        </select>
                    </form>
                </div>
            </div>

            {{-- Danger Zone --}}
            <div style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #FEE2E2;">
                <h3 style="font-size: 18px; font-weight: 700; margin: 0 0 16px; color: #991B1B;">⚠️ منطقة الخطر</h3>

                <form action="{{ route('user.quotation.delete', $quotation->id) }}" method="POST"
                      onsubmit="return confirm('هل أنت متأكّد من حذف عرض السعر هذا؟ لا يمكن التراجع عن هذا الإجراء.')">
                    @csrf
                    <button type="submit"
                            style="width: 100%; background: #EF4444; color: white; padding: 12px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 14px;">
                        🗑️ حذف عرض السعر
                    </button>
                </form>

                <p style="color: #991B1B; font-size: 12px; margin: 12px 0 0; line-height: 1.4;">
                    ⚠️ لا يمكن حذف عرض سعر مقبول. سيتم حذف كافّة البنود المرتبطة.
                </p>
            </div>

            {{-- Quick Actions --}}
            <div style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #E2E8F0; margin-top: 20px;">
                <h3 style="font-size: 18px; font-weight: 700; margin: 0 0 16px; color: #0F172A;">⚡ إجراءات سريعة</h3>

                <a href="{{ route('user.quotation.list') }}"
                   style="display: block; width: 100%; text-align: center; background: #F1F5F9; color: #475569; padding: 10px; border-radius: 8px; text-decoration: none; font-weight: 700; margin-bottom: 8px;">
                    📋 العودة للقائمة
                </a>

                <a href="{{ route('user.quotation.create') }}"
                   style="display: block; width: 100%; text-align: center; background: #EEF2FF; color: #4F46E5; padding: 10px; border-radius: 8px; text-decoration: none; font-weight: 700;">
                    ➕ عرض سعر جديد
                </a>
            </div>
        </div>

    </div>

</div>
@endsection