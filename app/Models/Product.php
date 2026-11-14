<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
