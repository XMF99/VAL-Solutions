<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashRegister extends Model
{
    protected $casts = [
        'user_id'         => 'integer',
        'parent_id'       => 'integer',

        'starting_time'   => 'datetime',
        'closing_time'    => 'datetime',

        'starting_amount' => 'double',
        'closing_amount'  => 'double',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
