<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'price',
        'server_specs',
        'short_description',
        'full_description',
        'image_url',
        'sort_order'
    ];

    protected static function booted(): void
    {
        static::deleting(function (Product $product): void {
            $product->contacts()->update(['product_id' => null]);
        });
    }

    protected function casts(): array 
    {
        return ['sort_order' => 'integer'];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function serviceRequest()
    {
        return $this->hasMany(ServiceRequest::class)->whereNotNull('status');
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }
}
