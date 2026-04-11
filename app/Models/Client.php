<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    // تحديد الحقول القابلة للتعبئة
    protected $fillable = [
        'full_name',
        'address',
        'representative_name',
        'client_phone',
        'representative_phone',
        'tax_registration_number',
        'email',
    ];
}