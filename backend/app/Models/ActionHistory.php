<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionHistory extends Model
{
    /** @use HasFactory<\Database\Factories\ActionHistoryFactory> */
    use HasFactory;

    protected $fillable = [
        'type_action',
        'info_action',
        'date_action',
        'user_id',
    ];
}
