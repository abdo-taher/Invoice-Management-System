<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'client_id',
        'car_number',
        'load_type',
        'project_value',
        'basic_value',
        'transport_price',
        'oman_khatmat_milah',
        'sharjah_khatmat_milah',
        'ras_dura',
        'dura_oman',
        'sharjah_daba',
        'other_expenses',
        'tarif',
        'warad',
        'total_paid_expenses',
        'total_unpaid_expenses',
        'net_amount',
        'payment_status',
        'invoice_number',
        'notes',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
