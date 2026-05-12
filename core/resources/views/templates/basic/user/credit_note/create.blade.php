@extends($activeTemplate . 'layouts.master')

@section('panel')
<div class="panel-content" dir="rtl" style="padding: 1.5rem;">
    
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="m-0">إنشاء إشعار دائن</h4>
            <p class="text-muted small m-0 mt-1">إصدار إشعار دائن لعميل</p>
        </div>
        <a href="{{ route('user.credit-note.list') }}" class="btn btn-outline-secondary btn-sm">
            <i class="las la-arrow-right"></i> رجوع للقائمة
        </a>
    </div>

    <form action="{{ route('user.credit-note.store') }}" method="POST">
        @csrf

        <div class="row g-3">
            
            {{-- العمود الأيسر: المعلومات الأساسيّة --}}
            <div class="col-lg-8">
                
                {{-- معلومات الإشعار --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <strong>معلومات الإشعار</strong>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">العميل <span class="text-danger">*</span></label>
                                <select name="customer_id" class="form-control" required>
                                    <option value="">— اختر العميل —</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" 
                                            {{ ($sale->customer_id ?? null) == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }} 
                                            @if($customer->mobile) ({{ $customer->mobile }}) @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">تاريخ الإشعار <span class="text-danger">*</span></label>
                                <input type="date" name="credit_note_date" class="form-control" 
                                    value="{{ now()->format('Y-m-d') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">الفاتورة الأصليّة (اختياري)</label>
                                <input type="number" name="sale_id" class="form-control" 
                                    placeholder="رقم الفاتورة" 
                                    value="{{ $sale->id ?? '' }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">المستودع</label>
                                <select name="warehouse_id" class="form-control">
                                    <option value="0">— بدون مستودع —</option>
                                    @foreach($warehouses as $warehouse)
                                        <option value="{{ $warehouse->id }}"
                                            {{ ($sale->warehouse_id ?? null) == $warehouse->id ? 'selected' : '' }}>
                                            {{ $warehouse->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">سبب الإشعار</label>
                                <select name="reason" class="form-control">
                                    <option value="return">إرجاع منتج</option>
                                    <option value="damage">منتج تالف</option>
                                    <option value="discount">خصم متأخّر</option>
                                    <option value="error">خطأ في الفاتورة</option>
                                    <option value="other">أخرى</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">يؤثّر على المخزون؟</label>
                                <div class="form-check mt-2">
                                    <input type="checkbox" name="affects_inventory" value="1" 
                                        class="form-check-input" checked>
                                    <label class="form-check-label">نعم، يرجع المنتج للمخزون</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">ملاحظات</label>
                                <textarea name="note" class="form-control" rows="2" 
                                    placeholder="ملاحظات إضافيّة..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- المنتجات --}}
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong>المنتجات المُرتجعة</strong>
                        <button type="button" class="btn btn-sm btn-success" onclick="addProductRow()">
                            <i class="las la-plus"></i> إضافة منتج
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="productsTable">
                                <thead style="background: #f8fafc;">
                                    <tr>
                                        <th>المنتج</th>
                                        <th width="100">الكميّة</th>
                                        <th width="120">السعر</th>
                                        <th width="120">الإجمالي</th>
                                        <th width="50"></th>
                                    </tr>
                                </thead>
                                <tbody id="productsBody">
                                    @if($sale && $sale->saleDetails)
                                        @foreach($sale->saleDetails as $idx => $detail)
                                            <tr>
                                                <td>
                                                    <input type="hidden" name="products[{{ $idx }}][product_id]" value="{{ $detail->product_id }}">
                                                    <input type="hidden" name="products[{{ $idx }}][product_details_id]" value="{{ $detail->product_details_id }}">
                                                    <input type="hidden" name="products[{{ $idx }}][original_sale_detail_id]" value="{{ $detail->id }}">
                                                    <input type="text" class="form-control" 
                                                        value="منتج #{{ $detail->product_id }}" readonly>
                                                </td>
                                                <td>
                                                    <input type="number" name="products[{{ $idx }}][quantity]" 
                                                        class="form-control qty-input" 
                                                        value="{{ $detail->quantity }}" 
                                                        max="{{ $detail->quantity }}" 
                                                        min="1" required onchange="calculateRow(this)">
                                                </td>
                                                <td>
                                                    <input type="number" name="products[{{ $idx }}][unit_price]" 
                                                        class="form-control price-input" 
                                                        value="{{ $detail->unit_price }}" 
                                                        step="0.01" required onchange="calculateRow(this)">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control subtotal-input" 
                                                        value="{{ number_format($detail->subtotal, 2) }}" readonly>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                                        onclick="removeRow(this)">
                                                        <i class="las la-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-3">
                                                لم تتم إضافة منتجات بعد
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- العمود الأيمن: الإجمالي --}}
            <div class="col-lg-4">
                <div class="card sticky-top" style="top: 1rem;">
                    <div class="card-header">
                        <strong>ملخّص الإشعار</strong>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">المجموع الفرعي:</span>
                            <strong id="subtotal">0.00 ر</strong>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small">خصم إضافي</label>
                            <input type="number" name="discount_amount" class="form-control form-control-sm" 
                                value="0" step="0.01" onchange="calculateTotal()">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small">شحن</label>
                            <input type="number" name="shipping_amount" class="form-control form-control-sm" 
                                value="0" step="0.01" onchange="calculateTotal()">
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <strong>الإجمالي:</strong>
                            <strong style="color: #10b981; font-size: 1.5rem;" id="total">0.00 ر</strong>
                        </div>

                        <button type="submit" class="btn btn-success w-100 mt-3">
                            <i class="las la-save"></i> حفظ الإشعار الدائن
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('script')
<script>
function addProductRow() {
    const tbody = document.getElementById('productsBody');
    const idx = tbody.querySelectorAll('tr').length;
    
    const row = `
        <tr>
            <td>
                <input type="hidden" name="products[${idx}][product_id]" value="0">
                <input type="hidden" name="products[${idx}][product_details_id]" value="0">
                <input type="text" class="form-control" name="products[${idx}][product_name]" placeholder="اسم المنتج">
            </td>
            <td><input type="number" name="products[${idx}][quantity]" class="form-control qty-input" min="1" value="1" onchange="calculateRow(this)"></td>
            <td><input type="number" name="products[${idx}][unit_price]" class="form-control price-input" step="0.01" onchange="calculateRow(this)"></td>
            <td><input type="text" class="form-control subtotal-input" readonly value="0.00"></td>
            <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)"><i class="las la-times"></i></button></td>
        </tr>
    `;
    tbody.insertAdjacentHTML('beforeend', row);
}

function removeRow(btn) {
    btn.closest('tr').remove();
    calculateTotal();
}

function calculateRow(input) {
    const row = input.closest('tr');
    const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
    const price = parseFloat(row.querySelector('.price-input').value) || 0;
    const subtotal = qty * price;
    row.querySelector('.subtotal-input').value = subtotal.toFixed(2);
    calculateTotal();
}

function calculateTotal() {
    let subtotal = 0;
    document.querySelectorAll('.subtotal-input').forEach(input => {
        subtotal += parseFloat(input.value) || 0;
    });
    const discount = parseFloat(document.querySelector('[name="discount_amount"]').value) || 0;
    const shipping = parseFloat(document.querySelector('[name="shipping_amount"]').value) || 0;
    const total = subtotal - discount + shipping;
    
    document.getElementById('subtotal').innerText = subtotal.toFixed(2) + ' ر';
    document.getElementById('total').innerText = total.toFixed(2) + ' ر';
}

// Initial calculation
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.qty-input').forEach(input => calculateRow(input));
});
</script>
@endpush
@endsection
