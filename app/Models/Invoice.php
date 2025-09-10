<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_email',
        'user_id',
        'subtotal',
        'discount',
        'tax',
        'shipping',
        'total',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function invoiceItem()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
