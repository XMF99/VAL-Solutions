<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Language extends Model
{
    protected $guarded  = ['id'];

    protected $casts = [
        'id'         => 'integer',
        'is_default' => 'integer',
    ];

    public function imageSrc(): Attribute
    {
        return new Attribute(
            get: fn() => getImage(getFilePath('language') . '/' . @$this->image, getFileSize('language')),
        );
    }
}
