<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
   protected $guarded  = ['id'];

   protected $casts = [
      'id'         => 'integer',
      'user_id'    => 'integer',
      'model_id'   => 'integer',
      'is_api'     => 'integer'
   ];

   public function user()
   {
      return $this->belongsTo(User::class);
   }
}
