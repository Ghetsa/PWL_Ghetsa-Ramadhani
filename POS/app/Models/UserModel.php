<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable; // implementasi class Authenticatable

class UserModel extends Authenticatable
{

   // ============================
   // | JOBSHEET 4 - PRAKTIKUM 1 |
   // ============================
   use HasFactory;

   protected $table = 'm_user'; // mendifinisikan nama tabel yang digunakan oleh model ini
   protected $primaryKey = 'user_id'; // mendefinisikan primary key dari tabel yang digunakan

   protected $hidden = ['password'];
   protected $casts = ['password' => 'hashed'];

    // --------------------------------------
    // Jobsheet 7 Praktikum 2 langkah 1
    // --------------------------------------
    // Relasi ke tabel level
    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    // Mendapatkan nama role
    public function getRoleName(): string
    {
        return $this->level->level_nama;
    }

    // Cek apakah user memiliki role tertentu
    public function hasRole($role): bool
    {
        // dd($this->level->attributes); // Cek semua atribut yang dimiliki LevelModel
        return $this->level->level_kode == $role;
    }

    
    // Mendapatkan kode role
    public function getRole()
    {
        return $this->level->level_kode;
    }
}