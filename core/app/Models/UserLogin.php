<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'id'         => 'integer',
        'user_id'    => 'integer',
        'driver_id'  => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
