<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use App\Traits\RecycleBinManager;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    use GlobalStatus, RecycleBinManager;

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
