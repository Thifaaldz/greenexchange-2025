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
        Schema::create('units', function (Blueprint $table) {
            $table->id();

            // Relasi ke branches
            $table->foreignId('branch_id')
                  ->nullable()
                  ->constrained('branches')
                  ->cascadeOnDelete();

            // Nama unit
            $table->string('name');

            // Kode unik (misalnya untuk QR)
            $table->string('code')->nullable();

            // Lokasi file QR Code
            $table->string('qr_path')->nullable();

            // Status aktif/nonaktif
            $table->enum('status', ['active', 'borrowed', 'inactive'])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
