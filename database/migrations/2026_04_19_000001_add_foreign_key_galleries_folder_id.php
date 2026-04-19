<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Menambahkan foreign key constraint untuk galleries.folder_id -> folders.id
     * Menggunakan cascadeOnDelete agar file dalam folder juga dihapus saat folder dihapus.
     */
    public function up(): void
    {
        // Pertama, pastikan tidak ada orphan records (folder_id yang tidak ada di folders)
        // Kita set NULL untuk record yang orphan
        \DB::statement('
            UPDATE galleries 
            SET folder_id = NULL 
            WHERE folder_id IS NOT NULL 
            AND folder_id NOT IN (SELECT id FROM folders WHERE deleted_at IS NULL)
        ');

        // Tambahkan foreign key dengan cascadeOnDelete
        Schema::table('galleries', function (Blueprint $table) {
            $table->foreignId('folder_id')
                  ->nullable()
                  ->constrained('folders')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropForeign(['folder_id']);
        });
    }
};