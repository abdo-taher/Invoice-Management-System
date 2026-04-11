<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'amount_paid',
        'remaining_balance',
        'payment_date',
    ];

    /**
     * العلاقة بين الدفعة والفاتورة
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * حساب الرصيد المتبقي بعد الدفعة
     *
     * @param float $totalAmount
     * @param float $paidAmount
     * @return float
     */
    public function calculateRemainingBalance($totalAmount, $paidAmount)
    {
        return $totalAmount - $paidAmount;
    }

    /**
     * تهيئة البيانات قبل الحفظ في قاعدة البيانات
     *
     * @param array $attributes
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($payment) {
            $invoice = $payment->invoice;
            $payment->remaining_balance = $payment->calculateRemainingBalance($invoice->total_amount, $invoice->paid_amount + $payment->amount_paid);
        });
    }
}
