<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title', 'author', 'primary_isbn10', 'primary_isbn13', 'book_image'];
}
