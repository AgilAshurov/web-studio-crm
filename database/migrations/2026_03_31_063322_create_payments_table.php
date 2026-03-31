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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')
                ->constrained('clients')
                ->cascadeOnDelete();
            $table->foreignId('project_id')
                ->nullable()
                ->constrained('projects')
                ->cascadeOnDelete();
            $table->foreignId('subscription_id')
                ->nullable()
                ->constrained('subscriptions')
                ->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->dateTime('payment_date');
            $table->string('payment_method')->nullable();
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
