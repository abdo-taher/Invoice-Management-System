<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade'); // الربط مع جدول العملاء
            $table->string('car_number');
            $table->string('load_type');
            $table->decimal('project_value', 10, 2);
            $table->decimal('basic_value', 10, 2);
            $table->decimal('transport_price', 10, 2);
            $table->decimal('oman_khatmat_milah', 10, 2);
            $table->decimal('sharjah_khatmat_milah', 10, 2);
            $table->decimal('ras_dura', 10, 2);
            $table->decimal('dura_oman', 10, 2);
            $table->decimal('sharjah_daba', 10, 2);
            $table->decimal('other_expenses', 10, 2);
            $table->decimal('tarif', 10, 2);
            $table->decimal('warad', 10, 2);
            $table->decimal('total_paid_expenses', 10, 2);
            $table->decimal('total_unpaid_expenses', 10, 2);
            $table->decimal('net_amount', 10, 2);
            $table->string('payment_status');
            $table->string('invoice_number');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('expenses');
    }
}
