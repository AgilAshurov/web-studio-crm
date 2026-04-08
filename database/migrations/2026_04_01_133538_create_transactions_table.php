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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->onDelete('restrict')->index();
            $table->enum('type',['debit','refund'])->index();
            $table->string('currency',3)->default('AZN')->index();
            $table->decimal('amount',10,2);
            $table->enum('status',['pending','success','failed'])->default('pending')->index();
            //$table->boolean('processing')->default(false);
            $table->uuid('reference')->unique();
            $table->timestamp('date')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
