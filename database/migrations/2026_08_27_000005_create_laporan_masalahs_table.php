<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_masalahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('nama_pelapor');
            $table->string('email_pelapor');
            $table->string('subject');
            $table->enum('kategori', ['bug', 'saran', 'akses', 'akademik', 'lainnya']);
            $table->text('deskripsi');
            $table->string('file_path')->nullable();
            $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])->default('open');
            $table->text('respon_admin')->nullable();
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'kategori']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_masalahs');
    }
};
