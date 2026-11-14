<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'title',
        'project_tag',
        'image_path',
        'caption',
        'sort_order'
    ];
}
