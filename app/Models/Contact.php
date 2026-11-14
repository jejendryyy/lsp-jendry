<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'user_id',
        'sender_name',
        'sender_email',
        'sender_phone',
        'product_id',
        'message',
        'read_at',
    ];
}
