<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles; // استيراد الـ Trait الخاص بالأدوار والصلاحيات

class Admin extends Model
{
    use HasFactory, HasRoles; // استخدام الـ Trait HasRoles

    // يمكن ترك هذا الحقل إذا كانت البيانات مخزنة في جدول باسم `admins`
    protected $table = 'admins';

    // تعيين الحارس الافتراضي
    protected $guard_name = 'web'; // تعيين الحارس المناسب، مثل "web" أو "admin"

    // إذا كنت تستخدم الحقول التالية وتريد التمكن من إدخالها بشكل مباشر
    protected $fillable = ['username', 'password'];
}
