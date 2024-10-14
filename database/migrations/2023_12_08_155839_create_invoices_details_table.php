<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_invoices');
            $table->string('Invoice_number');
            $table->foreign('id_Invoices')->references('id')->on('invoices')->onDelete('cascade');
            $table->string('product');
            $table->string('section');
            $table->string('status');
            $table->integer('value_status');
            $table->date('Payment_date')->nullable();
            $table->string('note')->nullable();
            $table->string('user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices_details');
    }
};
