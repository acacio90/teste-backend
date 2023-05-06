<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author', 'quantity'];

    protected static function newFactory()
    {
        return \Database\Factories\BookFactory::new();
    }
}
    