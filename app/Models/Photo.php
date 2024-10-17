<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model
{

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
//    protected $table = 'photos';
//    protected $fillable = [
//        'title',
//        'description'
//    ];
}


