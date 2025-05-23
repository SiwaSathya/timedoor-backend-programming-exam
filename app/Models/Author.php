<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function rates()
    {
        return $this->hasMany(Rates::class);
    }
}
