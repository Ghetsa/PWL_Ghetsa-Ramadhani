<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokModel extends Model
{
    use HasFactory;

    protected $table = 't_stok';
    protected $primaryKey = 'stok_id';
    protected $fillable = ['barang_id', 'user_id', 'supplier_id', 'stok_tanggal', 'stok_jumlah'];

    // Relasi ke Barang
    public function barang()
    {
        return $this->belongsTo(BarangModel::class, 'barang_id');
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }

    // Relasi ke Supplier (INI YANG BELUM ADA)
    public function supplier()
    {
        return $this->belongsTo(SupplierModel::class, 'supplier_id');
    }
}
