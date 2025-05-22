<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bookCategories()
    {
        return $this->belongsTo(BookCategories::class, 'category_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function rates()
    {
        return $this->hasMany(Rates::class);
    }
}
