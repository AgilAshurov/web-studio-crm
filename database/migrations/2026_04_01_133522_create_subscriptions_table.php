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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade')->index();
            $table->string('title')->index();
            $table->decimal('price',10,2);
            $table->enum('billing_period',['month','year'])->index();
            $table->date('start_date')->index();
            $table->date('next_invoice_date')->nullable()->index();
            $table->enum('payment_method',['cash','transfer'])->default('cash');
            $table->enum('status',['active','paused','canceled','expired'])->default('active')->index();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
