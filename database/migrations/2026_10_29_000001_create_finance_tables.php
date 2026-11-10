<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name', 80); $table->timestamps(); $table->unique(['user_id','name']);
        });
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->string('type', 10); $table->unsignedBigInteger('amount_cents');
            $table->date('date'); $table->string('description', 200)->nullable(); $table->timestamps();
            $table->index(['user_id','date']);
        });
    }
    public function down(): void { Schema::dropIfExists('transactions'); Schema::dropIfExists('categories'); }
};
