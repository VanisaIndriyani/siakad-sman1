<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            DB::statement('ALTER TABLE gurus MODIFY COLUMN nip VARCHAR(255) NULL');
        });

        Schema::table('siswas', function (Blueprint $table) {
            DB::statement('ALTER TABLE siswas MODIFY COLUMN nisn VARCHAR(255) NULL');
        });

        Schema::table('gurus', function (Blueprint $table) {
            if (!Schema::hasColumn('gurus', 'jenis_kelamin')) {
                DB::statement("ALTER TABLE gurus ADD COLUMN jenis_kelamin ENUM('L', 'P') NULL AFTER gelar_belakang");
            }
        });

        Schema::table('gurus', function (Blueprint $table) {
            if (!Schema::hasColumn('gurus', 'mapel_id')) {
                $table->foreignId('mapel_id')->nullable()->after('is_active')->constrained('mapels')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            if (Schema::hasColumn('gurus', 'mapel_id')) {
                $table->dropConstrainedForeignId('mapel_id');
            }
        });

        Schema::table('gurus', function (Blueprint $table) {
            if (Schema::hasColumn('gurus', 'jenis_kelamin')) {
                DB::statement('ALTER TABLE gurus DROP COLUMN jenis_kelamin');
            }
        });

        Schema::table('siswas', function (Blueprint $table) {
            DB::statement('ALTER TABLE siswas MODIFY COLUMN nisn VARCHAR(255) NOT NULL');
        });

        Schema::table('gurus', function (Blueprint $table) {
            DB::statement('ALTER TABLE gurus MODIFY COLUMN nip VARCHAR(255) NOT NULL');
        });
    }
};
