<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierModel extends Model
{
    use HasFactory;

    protected $table = 'm_supplier'; // Nama tabel di database

    protected $primaryKey = 'supplier_id'; // Primary Key

    public $incrementing = true; // Auto-increment (ubah ke false jika pakai UUID)

    protected $keyType = 'integer'; // Ubah ke 'string' jika pakai UUID

    protected $fillable = [
        'supplier_kode',
        'supplier_nama',
        'supplier_alamat'
    ];

    // Relasi ke tabel t_stok
    public function stok()
    {
        return $this->hasMany(StokModel::class, 'supplier_id', 'supplier_id');
    }
}