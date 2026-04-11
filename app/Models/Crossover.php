<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crossover extends Model
{
    use HasFactory;

    protected $fillable = [
        'weight',
        'manufacture',
        'civil_number',
        'driver_name',
        'from_province',
        'to_province',
        'truck_code',
        'truck_number',
        'company_name',
        'invoice_number',
        'shipment_date',
        'chassis_number', // رقم الشاصي
        'origin',         // المنشأ
        'color',          // اللون
        'vehicle_type',   // نوع المركبة
        'plate_type',     // نوع اللوحة
        'plate_code',     // رمز اللوحة
        'plate_number',   // رقم اللوحة
    ];
}
