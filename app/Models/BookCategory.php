<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nama_kategori', 'description'])]
class BookCategory extends Model

{
    //nama jamak menggunakan e/es karena bookcategories berperan sebagai many pada relasi one to many milik kategori baru
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
