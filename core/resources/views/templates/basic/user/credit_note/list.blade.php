@extends($activeTemplate . 'layouts.master')

@section('panel')
<div class="panel-content" dir="rtl" style="padding: 1.5rem;">
    
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="m-0">📋 إشعارات دائنة</h4>
            <p class="text-muted small m-0 mt-1">إدارة إشعارات الإرجاع والخصم المتأخّر للعملاء</p>
        </div>
        <a href="{{ route('user.credit-note.create') }}" class="btn btn-success">
            <i class="las la-plus"></i> إنشاء إشعار دائن
        </a>
    </div>

    {{-- Stats Cards --}}
    @php
        $activeCount = $creditNotes->where('status', 1)->count();
        $totalBalance = $creditNotes->where('status', 1)->sum('balance_amount');
        $appliedCount = $creditNotes->where('status', 2)->count();
    @endphp
    
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="card border-success">
                <div class="card-body">
                    <h6 class="text-muted small">إشعارات نشطة</h6>
                    <h3 style="color: #10b981;">{{ $activeCount }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-info">
                <div class="card-body">
                    <h6 class="text-muted small">إجمالي الرصيد المتاح</h6>
                    <h3 style="color: #3b82f6;">{{ number_format($totalBalance, 2) }} <small>ر.س</small></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-secondary">
                <div class="card-body">
                    <h6 class="text-muted small">مُطبّق بالكامل</h6>
                    <h3 style="color: #64748b;">{{ $appliedCount }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted small">إجمالي الإشعارات</h6>
                    <h3>{{ $creditNotes->total() }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card">
        <div class="card-body p-0">
            @if($creditNotes->count() > 0)
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead style="background: #f8fafc;">
                            <tr>
                                <th>الرقم</th>
                                <th>التاريخ</th>
                                <th>العميل</th>
                                <th>الفاتورة الأصليّة</th>
                                <th>المبلغ</th>
                                <th>الرصيد المتبقي</th>
                                <th>السبب</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($creditNotes as $note)
                                <tr>
                                    <td>
                                        <strong>{{ $note->credit_note_number }}</strong>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($note->credit_note_date)->format('Y-m-d') }}</td>
                                    <td>{{ $note->customer->name ?? '—' }}</td>
                                    <td>
                                        @if($note->original_invoice_number)
                                            <span class="text-muted small">{{ $note->original_invoice_number }}</span>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($note->total, 2) }} ر</td>
                                    <td>
                                        <strong style="color: #10b981;">{{ number_format($note->balance_amount, 2) }} ر</strong>
                                    </td>
                                    <td>{{ $note->reason_label }}</td>
                                    <td>
                                        <span class="badge {{ $note->status_badge }}">{{ $note->status_label }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('user.credit-note.show', $note->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="las la-eye"></i> عرض
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="p-3 d-flex justify-content-between align-items-center">
                    <span class="text-muted small">
                        عرض {{ $creditNotes->firstItem() }} - {{ $creditNotes->lastItem() }} من {{ $creditNotes->total() }}
                    </span>
                    {{ $creditNotes->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="las la-file-invoice" style="font-size: 4rem; color: #cbd5e1;"></i>
                    <h5 class="mt-3 mb-2">لا توجد إشعارات دائنة بعد</h5>
                    <p class="text-muted mb-3">ابدأ بإنشاء أوّل إشعار دائن لعميل</p>
                    <a href="{{ route('user.credit-note.create') }}" class="btn btn-success">
                        <i class="las la-plus"></i> إنشاء إشعار دائن
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
