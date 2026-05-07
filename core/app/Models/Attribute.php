<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use GlobalStatus, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'user_id'    => 'integer',
        'status'     => 'integer',
        'deleted_at' => 'datetime',
    ];

    public function variants()
    {
        return $this->hasMany(Variant::class, 'attribute_id');
    }
}
