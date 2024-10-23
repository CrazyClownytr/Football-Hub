<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   

    // Stel de table naam in, als deze niet de standaard naam volgt
    protected $table = 'categories';

    // De attributen die massaal toewijsbaar zijn
    protected $fillable = [
        'leagues', // Dit is het veld dat de categorie beschrijft
    ];

    // Relatie met foto's
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}
