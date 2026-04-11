<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'service_name',
        'service_description',
        'unit_id',
        'quantity',
        'price',
        'discount', // إضافة حقل الخصم
        'subtotal',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function calculateSubtotal()
    {
        $subtotal = ($this->quantity * $this->price) - $this->discount;
        return max($subtotal, 0); // التأكد من أن الإجمالي الفرعي لا يكون سالبًا
    }
}
