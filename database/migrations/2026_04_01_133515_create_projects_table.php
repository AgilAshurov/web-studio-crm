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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('restrict')->index();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('total_amount',10,2)->default(0);
            $table->enum('status',['draft','active','completed','paused','canceled'])->default('draft')->index();
            $table->json('notes')->nullable();
            $table->timestamps();

            $table->fullText(['title', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
