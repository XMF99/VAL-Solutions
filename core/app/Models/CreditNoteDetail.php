<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditNoteDetail extends Model
{
    protected $casts = [
        'unit_price'      => 'decimal:2',
        'sale_price'      => 'decimal:2',
        'purchase_price'  => 'decimal:2',
        'tax_amount'      => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'subtotal'        => 'decimal:2',
    ];

    // ═══════════════════════════════════════════════════════════
    // Relationships
    // ═══════════════════════════════════════════════════════════

    public function creditNote()
    {
        return $this->belongsTo(CreditNote::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productDetail()
    {
        return $this->belongsTo(ProductDetail::class, 'product_details_id');
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    public function originalSaleDetail()
    {
        return $this->belongsTo(SaleDetails::class, 'original_sale_detail_id');
    }
}
