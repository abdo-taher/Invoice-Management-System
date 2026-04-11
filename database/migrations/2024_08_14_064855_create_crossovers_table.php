<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrossoversTable extends Migration
{
    public function up()
    {
        Schema::create('crossovers', function (Blueprint $table) {
            $table->id();
            $table->string('weight');
            $table->string('manufacture');
            $table->string('civil_number');
            $table->string('driver_name');
            $table->string('from_province');
            $table->string('to_province');
            $table->string('truck_code');
            $table->string('truck_number');
            $table->string('company_name');
            $table->string('invoice_number');
            $table->date('shipment_date');
            // الحقول الجديدة
            $table->string('chassis_number'); // رقم الشاصي
            $table->string('origin');         // المنشأ
            $table->string('color');          // اللون
            $table->string('vehicle_type');   // نوع المركبة
            $table->string('plate_type');     // نوع اللوحة
            $table->string('plate_code');     // رمز اللوحة
            $table->string('plate_number');   // رقم اللوحة
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('crossovers');
    }
}
