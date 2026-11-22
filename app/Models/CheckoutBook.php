<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


#[Fillable(['checkout_id', 'book_id', 'total_book', 'subscription_package_id', 'price'])]
class CheckoutBook extends Model
{
    protected $table = 'checkout_books';

    public function checkout(): BelongsTo
    {
        return $this->belongsTo(Checkout::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
