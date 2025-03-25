<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\KategoriModel;

class BarangModel extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'm_barang';

    // Primary key yang digunakan
    protected $primaryKey = 'barang_id';

    // Kolom yang boleh diisi secara mass assignment
    protected $fillable = [
        'kategori_id',
        'barang_kode',
        'barang_nama',
        'harga_beli',
        'harga_jual'
    ];

    /**
     * Relasi ke model KategoriModel
     * belongsTo => many barang to one kategori
     */
    public function kategori(): BelongsTo
    {
        // 'kategori_id' di m_barang merujuk ke 'kategori_id' di m_kategori
        return $this->belongsTo(KategoriModel::class, 'kategori_id', 'kategori_id');
    }
}
