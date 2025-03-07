<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('invoice_number');
            $table->string('products_name');
            $table->string('seller');
            $table->string('value');
            $table->string('currency');
            $table->string('customer_name');
            $table->string('date_purchase');
            $table->binary('invoice_file');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE invoices MODIFY COLUMN invoice_file MEDIUMBLOB');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
