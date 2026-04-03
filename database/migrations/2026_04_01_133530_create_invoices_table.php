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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('restrict');
            $table->foreignId('project_id')->nullable()->constrained()->onDelete('restrict');
            $table->foreignId('subscription_id')->nullable()->constrained()->onDelete('restrict');
            $table->date('billing_period_start')->index();
            $table->date('billing_period_end')->index();
            $table->string('currency',3)->default('AZN')->index();
            $table->decimal('amount',10,2);
            $table->decimal('factical_amount',10,2)->default(0);
            $table->timestamp('payment_date')->nullable()->index();
            $table->enum('payment_method',['cash','transfer'])->nullable();
            $table->enum('status',['pending','partially_paid','refuned','partially_refuned','paid','canceled'])->default('pending')->index();
            $table->json('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
