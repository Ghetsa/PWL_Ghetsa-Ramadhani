<?php
// Mengimpor class yang diperlukan untuk migration
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Mengembalikan instance kelas anonim yang mewarisi Migration
return new class extends Migration
{
    /**
     * Run the migrations. Method untuk menjalankan migration (membuat tabel)
     */
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id(); // Membuat kolom id (primary key, auto-increment)
            $table->string('name'); // Membuat kolom name bertipe string (VARCHAR)
            $table->text('description'); // Membuat kolom description bertipe text (TEXT)
            $table->timestamps(); // Membuat kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations. Method untuk membatalkan migration (menghapus tabel)
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');  // Menghapus tabel stocks jika ada
    }
};
