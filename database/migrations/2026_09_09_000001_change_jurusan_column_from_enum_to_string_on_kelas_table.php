<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE `kelas` MODIFY COLUMN `jurusan` VARCHAR(50) NOT NULL DEFAULT '1'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `kelas` MODIFY COLUMN `jurusan` ENUM('IPA','IPS','BAHASA') NOT NULL DEFAULT 'IPA'");
    }
};
