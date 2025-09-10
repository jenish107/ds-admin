<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $fillable = [
        'product_name',
        'price'
    ];

    public function InvoiceItem()
    {
        return $this->hasOne(InvoiceItem::class);
    }
}
