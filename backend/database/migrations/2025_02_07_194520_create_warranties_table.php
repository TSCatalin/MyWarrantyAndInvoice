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
        Schema::create('warranties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('warranty_id');
            $table->string('invoice_number');
            $table->string('product_name');
            $table->string('seller');
            $table->string('customer_name');
            $table->string('date_purchase');
            $table->string('warranty_end_date');
            $table->boolean('status')->default(false);
            $table->binary('warranty_file');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE warranties MODIFY COLUMN warranty_file MEDIUMBLOB');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warranties');
    }
};
