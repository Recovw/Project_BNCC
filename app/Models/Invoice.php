<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['invoice_number', 'shipping_address', 'postal_code', 'total'];

    public function items() {
        return $this->hasMany(InvoiceItem::class);
    }
}
