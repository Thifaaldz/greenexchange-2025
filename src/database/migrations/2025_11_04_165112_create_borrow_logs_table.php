<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('borrow_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained()->cascadeOnDelete();
            $table->string('borrower_name'); // nama peminjam
            $table->string('borrower_contact')->nullable(); // kontak opsional
            $table->dateTime('borrowed_at'); // tanggal pinjam
            $table->dateTime('returned_at')->nullable(); // tanggal kembali
            $table->enum('status', ['borrowed', 'returned'])->default('borrowed');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrow_logs');
    }
};
