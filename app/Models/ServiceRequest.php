<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceRequest extends Model
{
    public const STATUS_WAITING = 'waiting';

    public const STATUS_APPROVED = 'approved';

    public const STATUS_ACTIVE = 'active';

    public const STATUS_NONACTIVE = 'non active';

    public const STATUSES = [
        self::STATUS_WAITING,
        self::STATUS_APPROVED,
        self::STATUS_ACTIVE,
        self::STATUS_NONACTIVE,
    ];

    protected $fillable = [
        'user_id',
        'product_id',
        'sender_name',
        'sender_email',
        'sender_phone',
        'message',
        'status',
    ];

    protected $table = 'contacts';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
