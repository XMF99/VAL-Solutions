@extends($activeTemplate . 'layouts.master')

@section('panel')
<div style="padding: 20px; font-family: 'Cairo','Tajawal',sans-serif; direction: rtl;">

    {{-- ═══════ Header ═══════ --}}
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 28px; font-weight: 900; margin: 0; color: #0F172A;">
            ➕ إنشاء مرتجع بيع
        </h1>
        <p style="color: #64748B; margin: 4px 0 0;">إرجاع منتجات من فاتورة بيع واسترداد المبلغ</p>
    </div>

    <form action="{{ route('user.sale_return.store') }}" method="POST" id="returnForm">
        @csrf

        {{-- ═══════ Card 1: اختيار الفاتورة ═══════ --}}
        <div style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #E2E8F0; margin-bottom: 20px;">
            <h3 style="font-size: 18px; font-weight: 700; margin: 0 0 20px; color: #0F172A;">📄 الفاتورة الأصلية</h3>

            @if($sales->count() > 0)
                <div>
                    <label style="display: block; font-weight: 700; margin-bottom: 8px; color: #334155;">
                        اختر الفاتورة <span style="color: #EF4444;">*</span>
                    </label>
                    <select name="sale_id" id="saleSelect" required onchange="loadSaleItems()"
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
                    <small style="color: #64748B; font-size: 12px; display: block; margin-top: 4px;">اختر الفاتورة التي تريد إرجاع منتجات منها</small>
                </div>

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
                            <div style="color: #64748B; font-size: 12px; margin-bottom: 4px;">إجمالي الفاتورة</div>
                            <div id="saleTotal" style="font-weight: 700; color: #10B981; font-size: 18px;">-</div>
                        </div>
                    </div>
                </div>

            @else
                <div style="padding: 40px; text-align: center; background: #FEF3C7; border-radius: 12px; border: 1px solid #FDE68A;">
                    <div style="font-size: 48px; margin-bottom: 12px;">⚠️</div>
                    <h4 style="color: #92400E; margin: 0 0 8px;">لا توجد فواتير متاحة</h4>
                    <p style="color: #B45309; margin: 0;">لا توجد فواتير بيع حالياً للإرجاع منها.</p>
                </div>
            @endif

        </div>

        @if($sales->count() > 0)
        {{-- ═══════ Card 2: تفاصيل المرتجع ═══════ --}}
        <div style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #E2E8F0; margin-bottom: 20px;">
            <h3 style="font-size: 18px; font-weight: 700; margin: 0 0 20px; color: #0F172A;">📋 تفاصيل المرتجع</h3>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 16px; margin-bottom: 20px;">
                
                <div>
                    <label style="display: block; font-weight: 700; margin-bottom: 8px; color: #334155;">
                        تاريخ المرتجع <span style="color: #EF4444;">*</span>
                    </label>
                    <input type="date" name="return_date" value="{{ date('Y-m-d') }}" required
                           style="width: 100%; padding: 10px 16px; border: 1px solid #E2E8F0; border-radius: 8px; font-family: inherit;">
                </div>

                <div>
                    <label style="display: block; font-weight: 700; margin-bottom: 8px; color: #334155;">
                        طريقة رد المبلغ <span style="color: #EF4444;">*</span>
                    </label>
                    <select name="refund_method" required
                            style="width: 100%; padding: 10px 16px; border: 1px solid #E2E8F0; border-radius: 8px; font-family: inherit;">
                        <option value="cash">💵 نقدي</option>
                        <option value="credit">🔄 رصيد</option>
                        <option value="exchange">🔁 استبدال</option>
                    </select>
                </div>

            </div>

            <div>
                <label style="display: block; font-weight: 700; margin-bottom: 8px; color: #334155;">سبب الإرجاع</label>
                <textarea name="return_reason" rows="2" placeholder="سبب إرجاع المنتج..."
                          style="width: 100%; padding: 12px; border: 1px solid #E2E8F0; border-radius: 8px; font-family: inherit; resize: vertical;"></textarea>
            </div>
        </div>

        {{-- ═══════ Card 3: البنود المرتجعة ═══════ --}}
        <div style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #E2E8F0; margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <h3 style="font-size: 18px; font-weight: 700; margin: 0; color: #0F172A;">🛒 البنود المرتجعة</h3>
                <button type="button" onclick="addReturnItem()"
                        style="background: #EF4444; color: white; padding: 8px 16px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer;">
                    ➕ إضافة بند
                </button>
            </div>

            <div id="itemsContainer">
                <div class="return-item" style="padding: 16px; background: #F8FAFC; border-radius: 12px; margin-bottom: 12px;">
                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: 12px; align-items: end;">
                        <div>
                            <label style="font-size: 13px; font-weight: 700; color: #64748B;">المنتج</label>
                            <input type="text" name="items[0][product_name]" placeholder="اسم المنتج" required
                                   style="width: 100%; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px; font-family: inherit;">
                        </div>
                        <div>
                            <label style="font-size: 13px; font-weight: 700; color: #64748B;">الكمية</label>
                            <input type="number" name="items[0][quantity]" step="0.01" value="1" required
                                   style="width: 100%; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px; font-family: inherit;">
                        </div>
                        <div>
                            <label style="font-size: 13px; font-weight: 700; color: #64748B;">السعر</label>
                            <input type="number" name="items[0][unit_price]" step="0.01" value="0" required
                                   style="width: 100%; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px; font-family: inherit;">
                        </div>
                        <div>
                            <label style="font-size: 13px; font-weight: 700; color: #64748B;">الضريبة %</label>
                            <input type="number" name="items[0][tax_rate]" step="0.01" value="0" min="0" max="100"
                                   style="width: 100%; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px; font-family: inherit;">
                        </div>
                        <button type="button" onclick="removeReturnItem(this)"
                                style="background: #F87171; color: white; padding: 8px 12px; border: none; border-radius: 6px; cursor: pointer;">🗑️</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══════ Actions ═══════ --}}
        <div style="display: flex; gap: 12px; justify-content: flex-end;">
            <a href="{{ route('user.sale_return.list') }}"
               style="background: #F1F5F9; color: #475569; padding: 12px 28px; border-radius: 10px; text-decoration: none; font-weight: 700;">
                إلغاء
            </a>
            <button type="submit"
                    style="background: linear-gradient(135deg, #EF4444, #DC2626); color: white; padding: 12px 32px; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 12px rgba(239,68,68,0.3);">
                ✅ إنشاء المرتجع
            </button>
        </div>
        @endif

    </form>

</div>

<script>
let itemIndex = 1;

function loadSaleItems() {
    const select = document.getElementById('saleSelect');
    const option = select.options[select.selectedIndex];
    
    if (!option.value) {
        document.getElementById('saleInfo').style.display = 'none';
        return;
    }

    document.getElementById('invoiceNo').textContent = option.dataset.invoice;
    document.getElementById('customerName').textContent = option.dataset.customer;
    document.getElementById('saleTotal').textContent = parseFloat(option.dataset.total).toFixed(2) + ' ريال';
    
    document.getElementById('saleInfo').style.display = 'block';
}

function addReturnItem() {
    const container = document.getElementById('itemsContainer');
    const newItem = document.createElement('div');
    newItem.className = 'return-item';
    newItem.style.cssText = 'padding: 16px; background: #F8FAFC; border-radius: 12px; margin-bottom: 12px;';
    newItem.innerHTML = `
        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: 12px; align-items: end;">
            <div>
                <label style="font-size: 13px; font-weight: 700; color: #64748B;">المنتج</label>
                <input type="text" name="items[${itemIndex}][product_name]" placeholder="اسم المنتج" required
                       style="width: 100%; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px; font-family: inherit;">
            </div>
            <div>
                <label style="font-size: 13px; font-weight: 700; color: #64748B;">الكمية</label>
                <input type="number" name="items[${itemIndex}][quantity]" step="0.01" value="1" required
                       style="width: 100%; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px; font-family: inherit;">
            </div>
            <div>
                <label style="font-size: 13px; font-weight: 700; color: #64748B;">السعر</label>
                <input type="number" name="items[${itemIndex}][unit_price]" step="0.01" value="0" required
                       style="width: 100%; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px; font-family: inherit;">
            </div>
            <div>
                <label style="font-size: 13px; font-weight: 700; color: #64748B;">الضريبة %</label>
                <input type="number" name="items[${itemIndex}][tax_rate]" step="0.01" value="0" min="0" max="100"
                       style="width: 100%; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px; font-family: inherit;">
            </div>
            <button type="button" onclick="removeReturnItem(this)"
                    style="background: #F87171; color: white; padding: 8px 12px; border: none; border-radius: 6px; cursor: pointer;">🗑️</button>
        </div>
    `;
    container.appendChild(newItem);
    itemIndex++;
}

function removeReturnItem(btn) {
    const items = document.querySelectorAll('.return-item');
    if (items.length > 1) {
        btn.closest('.return-item').remove();
    } else {
        alert('يجب أن يحتوي المرتجع على بند واحد على الأقل');
    }
}
</script>

@endsection