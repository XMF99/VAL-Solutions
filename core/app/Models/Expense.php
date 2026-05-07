<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;

    protected $guarded  = ['id'];

    protected $casts = [
        'id'              => 'integer',
        'user_id'         => 'integer',
        'category_id'     => 'integer',
        'payment_type_id' => 'integer',
        'added_by'        => 'integer',
        'expense_date'    => 'date',
        'amount'          => 'double',
        'deleted_at'      => 'datetime',

    ];

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type_id');
    }

    public function exportColumns(): array
    {
        return  [
            'category_id' => [
                'name' => "purpose",
                'callback' => function ($item) {
                    return @$item->category->name;
                }
            ],
            'expense_date',
            'reference_no',
            'comment',
            "amount" => [
                'callback' => function ($item) {
                    return showAmount($item->amount);
                }
            ]
        ];
    }
}
