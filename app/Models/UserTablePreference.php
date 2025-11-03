<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTablePreference extends Model
{
   protected $table = 'user_table_preferences';

    protected $fillable = [
        'user_id',
        'table_key',
        'visible_columns',
    ];

    protected $casts = [
        'visible_columns' => 'array',
    ];
}
