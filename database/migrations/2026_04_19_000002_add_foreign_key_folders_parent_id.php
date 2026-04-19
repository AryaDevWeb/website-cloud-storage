<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Menambahkan foreign key constraint untuk folders.parent_id -> folders.id
     * Menggunakan nullOnDelete agar subfolder menjadi root folder saat parent dihapus.
     */
    public function up(): void
    {
        // Pastikan tidak ada orphan records
        \DB::statement('
            UPDATE folders 
            SET parent_id = NULL 
            WHERE parent_id IS NOT NULL 
            AND parent_id NOT IN (SELECT id FROM folders WHERE deleted_at IS NULL)
        ');

        Schema::table('folders', function (Blueprint $table) {
            $table->foreignId('parent_id')
                  ->nullable()
                  ->constrained('folders')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('folders', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });
    }
};