<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffPermission extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'id' => 'integer',
    ];
}
