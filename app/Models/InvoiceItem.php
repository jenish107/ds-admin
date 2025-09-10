<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = [
<<<<<<< HEAD
        'quantity',
        'amount',
        'invoice_id',
        'product_id'
=======
        'item',
        'quantity',
        'rate',
        'amount',
        'invoice_id',
>>>>>>> bf239d4cf51b72047cf543048e33b97fb6e9abbe
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
<<<<<<< HEAD

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
=======
>>>>>>> bf239d4cf51b72047cf543048e33b97fb6e9abbe
}
