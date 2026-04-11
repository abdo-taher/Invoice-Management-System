<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'invoice_number',
        'invoice_date',
        'total_amount',
        'paid_amount',
        'status',
        'tax_id', // إضافة tax_id إلى fillable
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments()
    {
        return $this->hasMany(InvoicePayment::class);
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    public function calculateTotal()
    {
        $total = $this->items->sum(function($item) {
            return $item->subtotal;
        });

        return $total;
    }

    public function calculateRemainingBalance()
    {
        $totalPaid = $this->payments->sum('amount_paid');
        return $this->total_amount - $totalPaid;
    }
}
