<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


class Photo extends Model
{

    use softDeletes;

    protected $fillable = ['title', 'description', 'path', 'status'];

    protected static function boot()
    {
        parent::boot();

        // Bij het ophalen van foto's
        static::retrieved(function ($photo) {
            if ($photo->deleted_at) {
                $photo->status = 'inactive';
            }
        });
    }

    protected array $dates = ['deleted_at'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

}


