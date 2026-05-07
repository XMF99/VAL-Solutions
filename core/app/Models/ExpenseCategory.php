<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseCategory extends Model
{
    use GlobalStatus, SoftDeletes;

    protected $guarded  = ['id'];

    protected $casts = [
        'id'         => 'integer',
        'user_id'    => 'integer',
        'status'     => 'integer',
        'deleted_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
