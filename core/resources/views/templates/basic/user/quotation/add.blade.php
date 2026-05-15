@extends($activeTemplate . 'layouts.master')

@section('panel')
<div style="padding: 20px; font-family: 'Cairo','Tajawal',sans-serif; direction: rtl;">

    {{-- ═══════ Header ═══════ --}}
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 28px; font-weight: 900; margin: 0; color: #0F172A;">
            {{ isset($quotation) ? '✏️ تعديل عرض سعر' : '➕ إنشاء عرض سعر جديد' }}
        </h1>
        <p style="color: #64748B; margin: 4px 0 0;">
            {{ isset($quotation) ? 'عدّل بيانات عرض السعر ' . $quotation->quotation_no : 'أدخل تفاصيل عرض السعر الجديد' }}
        </p>
    </div>

    <form action="{{ isset($quotation) ? route('user.quotation.update', $quotation->id) : route('user.quotation.store') }}"
          method="POST" id="quotationForm">
        @csrf

        {{-- ═══════ Card 1: Basic Info ═══════ --}}
        <div style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #E2E8F0; margin-bottom: 20px;">
            <h3 style="font-size: 18px; font-weight: 700; margin: 0 0 20px; color: #0F172A;">📄 المعلومات الأساسيّة</h3>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 16px;">

                {{-- Quotation Number --}}
                <div>
                    <label style="display: block; font-weight: 700; margin-bottom: 8px; color: #334155;">رقم العرض</label>
                    <input type="text" name="quotation_no"
                           value="{{ $quotation->quotation_no ?? $nextQuotationNo ?? '' }}"
                           readonly
                           style="width: 100%; padding: 10px 16px; border: 1px solid #E2E8F0; border-radius: 8px; background: #F8FAFC; font-family: inherit;">
                </div>

                {{-- Customer --}}
                <div>
                    <label style="display: block; font-weight: 700; margin-bottom: 8px; color: #334155;">العميل <span style="color: #EF4444;">*</span></label>
                    <select name="customer_id" required
                            style="width: 100%; padding: 10px 16px; border: 1px solid #E2E8F0; border-radius: 8px; font-family: inherit;">
                        <option value="">-- اختر العميل --</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}" @selected(isset($quotation) && $quotation->customer_id == $c->id)>
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Quotation Date --}}
                <div>
                    <label style="display: block; font-weight: 700; margin-bottom: 8px; color: #334155;">تاريخ العرض <span style="color: #EF4444;">*</span></label>
                    <input type="date" name="quotation_date"
                           value="{{ isset($quotation) ? $quotation->quotation_date?->format('Y-m-d') : date('Y-m-d') }}"
                           required
                           style="width: 100%; padding: 10px 16px; border: 1px solid #E2E8F0; border-radius: 8px; font-family: inherit;">
                </div>

                {{-- Valid Until --}}
                <div>
                    <label style="display: block; font-weight: 700; margin-bottom: 8px; color: #334155;">صالح حتى <span style="color: #EF4444;">*</span></label>
                    <input type="date" name="valid_until"
                           value="{{ isset($quotation) ? $quotation->valid_until?->format('Y-m-d') : date('Y-m-d', strtotime('+30 days')) }}"
                           required
                           style="width: 100%; padding: 10px 16px; border: 1px solid #E2E8F0; border-radius: 8px; font-family: inherit;">
                </div>

            </div>
        </div>

        {{-- ═══════ Card 2: Items ═══════ --}}
        <div style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #E2E8F0; margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <h3 style="font-size: 18px; font-weight: 700; margin: 0; color: #0F172A;">🛒 البنود</h3>
                <button type="button" onclick="addRow()"
                        style="background: #10B981; color: white; padding: 8px 16px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer;">
                    ➕ إضافة بند
                </button>
            </div>

            <div style="overflow-x: auto;">
                <table id="itemsTable" style="width: 100%; border-collapse: collapse; min-width: 900px;">
                    <thead style="background: #F8FAFC;">
                        <tr>
                            <th style="padding: 10px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B;">المنتج</th>
                            <th style="padding: 10px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B; width: 100px;">الكميّة</th>
                            <th style="padding: 10px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B; width: 120px;">السعر</th>
                            <th style="padding: 10px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B; width: 100px;">خصم %</th>
                            <th style="padding: 10px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B; width: 100px;">ضريبة %</th>
                            <th style="padding: 10px; text-align: right; font-size: 13px; font-weight: 700; color: #64748B; width: 120px;">المجموع</th>
                            <th style="padding: 10px; text-align: center; font-size: 13px; font-weight: 700; color: #64748B; width: 60px;">حذف</th>
                        </tr>
                    </thead>
                    <tbody id="itemsBody">
                        @if(isset($quotation) && $quotation->items->count() > 0)
                            @foreach($quotation->items as $index => $item)
                            <tr class="item-row">
                                <td style="padding: 8px;">
                                    <select name="items[{{ $index }}][product_id]" class="product-select" onchange="selectProduct(this)"
                                            style="width: 100%; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px; font-family: inherit;">
                                        <option value="">-- منتج مخصّص --</option>
                                        @foreach($products as $p)
                                            <option value="{{ $p->id }}"
                                                    data-name="{{ $p->name }}"
                                                    data-price="{{ $p->selling_price ?? 0 }}"
                                                    @selected($item->product_id == $p->id)>
                                                {{ $p->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="text" name="items[{{ $index }}][product_name]" placeholder="اسم المنتج"
                                           value="{{ $item->product_name }}"
                                           required
                                           style="width: 100%; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px; margin-top: 4px; font-family: inherit;">
                                </td>
                                <td style="padding: 8px;">
                                    <input type="number" name="items[{{ $index }}][quantity]" class="qty" step="0.01" value="{{ $item->quantity }}" required oninput="calcRow(this)"
                                           style="width: 100%; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px; font-family: inherit;">
                                </td>
                                <td style="padding: 8px;">
                                    <input type="number" name="items[{{ $index }}][unit_price]" class="price" step="0.01" value="{{ $item->unit_price }}" required oninput="calcRow(this)"
                                           style="width: 100%; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px; font-family: inherit;">
                                </td>
                                <td style="padding: 8px;">
                                    <input type="number" name="items[{{ $index }}][discount]" class="discount" step="0.01" min="0" max="100" value="{{ $item->discount }}" oninput="calcRow(this)"
                                           style="width: 100%; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px; font-family: inherit;">
                                </td>
                                <td style="padding: 8px;">
                                    <input type="number" name="items[{{ $index }}][tax_rate]" class="tax" step="0.01" min="0" max="100" value="{{ $item->tax_rate }}" oninput="calcRow(this)"
                                           style="width: 100%; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px; font-family: inherit;">
                                </td>
                                <td style="padding: 8px;">
                                    <input type="text" class="row-total" readonly value="{{ number_format($item->total, 2) }}"
                                           style="width: 100%; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px; background: #F8FAFC; font-weight: 700; font-family: inherit;">
                                </td>
                                <td style="padding: 8px; text-align: center;">
                                    <button type="button" onclick="removeRow(this)"
                                            style="background: #EF4444; color: white; padding: 6px 12px; border: none; border-radius: 6px; cursor: pointer;">🗑️</button>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr class="item-row">
                                <td style="padding: 8px;">
                                    <select name="items[0][product_id]" class="product-select" onchange="selectProduct(this)"
                                            style="width: 100%; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px; font-family: inherit;">
                                        <option value="">-- منتج مخصّص --</option>
                                        @foreach($products as $p)
                                            <option value="{{ $p->id }}" data-name="{{ $p->name }}" data-price="{{ $p->selling_price ?? 0 }}">{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" name="items[0][product_name]" placeholder="اسم المنتج" required
                                           style="width: 100%; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px; margin-top: 4px; font-family: inherit;">
                                </td>
                                <td style="padding: 8px;"><input type="number" name="items[0][quantity]" class="qty" step="0.01" value="1" required oninput="calcRow(this)" style="width: 100%; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px; font-family: inherit;"></td>
                                <td style="padding: 8px;"><input type="number" name="items[0][unit_price]" class="price" step="0.01" value="0" required oninput="calcRow(this)" style="width: 100%; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px; font-family: inherit;"></td>
                                <td style="padding: 8px;"><input type="number" name="items[0][discount]" class="discount" step="0.01" min="0" max="100" value="0" oninput="calcRow(this)" style="width: 100%; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px; font-family: inherit;"></td>
                                <td style="padding: 8px;"><input type="number" name="items[0][tax_rate]" class="tax" step="0.01" min="0" max="100" value="0" oninput="calcRow(this)" style="width: 100%; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px; font-family: inherit;"></td>
                                <td style="padding: 8px;"><input type="text" class="row-total" readonly value="0.00" style="width: 100%; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px; background: #F8FAFC; font-weight: 700; font-family: inherit;"></td>
                                <td style="padding: 8px; text-align: center;"><button type="button" onclick="removeRow(this)" style="background: #EF4444; color: white; padding: 6px 12px; border: none; border-radius: 6px; cursor: pointer;">🗑️</button></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            {{-- Totals Summary --}}
            <div style="margin-top: 24px; padding: 16px; background: #F8FAFC; border-radius: 12px; max-width: 400px; margin-left: auto;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #64748B;">المجموع الفرعي:</span>
                    <span id="displaySubtotal" style="font-weight: 700;">0.00</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #64748B;">الخصم:</span>
                    <span id="displayDiscount" style="font-weight: 700; color: #EF4444;">0.00</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #64748B;">الضريبة:</span>
                    <span id="displayTax" style="font-weight: 700; color: #10B981;">0.00</span>
                </div>
                <div style="border-top: 2px solid #E2E8F0; padding-top: 8px; margin-top: 8px;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="font-weight: 900; font-size: 18px;">الإجمالي:</span>
                        <span id="displayTotal" style="font-weight: 900; font-size: 18px; color: #4F46E5;">0.00</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══════ Card 3: Notes ═══════ --}}
        <div style="background: white; padding: 24px; border-radius: 16px; border: 1px solid #E2E8F0; margin-bottom: 20px;">
            <h3 style="font-size: 18px; font-weight: 700; margin: 0 0 12px; color: #0F172A;">📝 ملاحظات</h3>
            <textarea name="notes" rows="4" placeholder="ملاحظات إضافيّة (اختياري)..."
                      style="width: 100%; padding: 12px; border: 1px solid #E2E8F0; border-radius: 8px; font-family: inherit; resize: vertical;">{{ $quotation->notes ?? '' }}</textarea>
        </div>

        {{-- ═══════ Actions ═══════ --}}
        <div style="display: flex; gap: 12px; justify-content: flex-end;">
            <a href="{{ route('user.quotation.list') }}"
               style="background: #F1F5F9; color: #475569; padding: 12px 28px; border-radius: 10px; text-decoration: none; font-weight: 700;">
                إلغاء
            </a>
            <button type="submit"
                    style="background: linear-gradient(135deg, #4F46E5, #7C3AED); color: white; padding: 12px 32px; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 12px rgba(79,70,229,0.3);">
                {{ isset($quotation) ? '💾 حفظ التعديلات' : '✅ إنشاء العرض' }}
            </button>
        </div>

    </form>

</div>

<script>
let rowIndex = {{ isset($quotation) ? $quotation->items->count() : 1 }};

// Add new item row
function addRow() {
    const tbody = document.getElementById('itemsBody');
    const row = document.createElement('tr');
    row.className = 'item-row';
    row.innerHTML = `
        <td style="padding: 8px;">
            <select name="items[${rowIndex}][product_id]" class="product-select" onchange="selectProduct(this)"
                    style="width: 100%; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px; font-family: inherit;">
                <option value="">-- منتج مخصّص --</option>
                @foreach($products as $p)
                    <option value="{{ $p->id }}" data-name="{{ $p->name }}" data-price="{{ $p->selling_price ?? 0 }}">{{ $p->name }}</option>
                @endforeach
            </select>
            <input type="text" name="items[${rowIndex}][product_name]" placeholder="اسم المنتج" required
                   style="width: 100%; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px; margin-top: 4px; font-family: inherit;">
        </td>
        <td style="padding: 8px;"><input type="number" name="items[${rowIndex}][quantity]" class="qty" step="0.01" value="1" required oninput="calcRow(this)" style="width: 100%; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px; font-family: inherit;"></td>
        <td style="padding: 8px;"><input type="number" name="items[${rowIndex}][unit_price]" class="price" step="0.01" value="0" required oninput="calcRow(this)" style="width: 100%; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px; font-family: inherit;"></td>
        <td style="padding: 8px;"><input type="number" name="items[${rowIndex}][discount]" class="discount" step="0.01" min="0" max="100" value="0" oninput="calcRow(this)" style="width: 100%; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px; font-family: inherit;"></td>
        <td style="padding: 8px;"><input type="number" name="items[${rowIndex}][tax_rate]" class="tax" step="0.01" min="0" max="100" value="0" oninput="calcRow(this)" style="width: 100%; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px; font-family: inherit;"></td>
        <td style="padding: 8px;"><input type="text" class="row-total" readonly value="0.00" style="width: 100%; padding: 8px; border: 1px solid #E2E8F0; border-radius: 6px; background: #F8FAFC; font-weight: 700; font-family: inherit;"></td>
        <td style="padding: 8px; text-align: center;"><button type="button" onclick="removeRow(this)" style="background: #EF4444; color: white; padding: 6px 12px; border: none; border-radius: 6px; cursor: pointer;">🗑️</button></td>
    `;
    tbody.appendChild(row);
    rowIndex++;
    calcTotal();
}

// Remove row
function removeRow(btn) {
    if (document.querySelectorAll('.item-row').length > 1) {
        btn.closest('tr').remove();
        calcTotal();
    } else {
        alert('يجب أن يحتوي العرض على بند واحد على الأقل');
    }
}

// Product selection
function selectProduct(select) {
    const option = select.options[select.selectedIndex];
    if (option.value) {
        const row = select.closest('tr');
        row.querySelector('[name*="[product_name]"]').value = option.dataset.name || '';
        row.querySelector('.price').value = option.dataset.price || 0;
        calcRow(row.querySelector('.qty'));
    }
}

// Calculate row total
function calcRow(input) {
    const row = input.closest('tr');
    const qty = parseFloat(row.querySelector('.qty').value) || 0;
    const price = parseFloat(row.querySelector('.price').value) || 0;
    const discountPercent = parseFloat(row.querySelector('.discount').value) || 0;
    const taxPercent = parseFloat(row.querySelector('.tax').value) || 0;

    const subtotal = qty * price;
    const discountAmount = subtotal * (discountPercent / 100);
    const afterDiscount = subtotal - discountAmount;
    const taxAmount = afterDiscount * (taxPercent / 100);
    const total = afterDiscount + taxAmount;

    row.querySelector('.row-total').value = total.toFixed(2);
    calcTotal();
}

// Calculate grand totals
function calcTotal() {
    let grandSubtotal = 0;
    let grandDiscount = 0;
    let grandTax = 0;

    document.querySelectorAll('.item-row').forEach(row => {
        const qty = parseFloat(row.querySelector('.qty').value) || 0;
        const price = parseFloat(row.querySelector('.price').value) || 0;
        const discountPercent = parseFloat(row.querySelector('.discount').value) || 0;
        const taxPercent = parseFloat(row.querySelector('.tax').value) || 0;

        const subtotal = qty * price;
        const discountAmount = subtotal * (discountPercent / 100);
        const afterDiscount = subtotal - discountAmount;
        const taxAmount = afterDiscount * (taxPercent / 100);

        grandSubtotal += subtotal;
        grandDiscount += discountAmount;
        grandTax += taxAmount;
    });

    const grandTotal = grandSubtotal - grandDiscount + grandTax;

    document.getElementById('displaySubtotal').textContent = grandSubtotal.toFixed(2);
    document.getElementById('displayDiscount').textContent = grandDiscount.toFixed(2);
    document.getElementById('displayTax').textContent = grandTax.toFixed(2);
    document.getElementById('displayTotal').textContent = grandTotal.toFixed(2);
}

// Initialize calculations on page load
document.addEventListener('DOMContentLoaded', function() {
    calcTotal();
});
</script>

@endsection