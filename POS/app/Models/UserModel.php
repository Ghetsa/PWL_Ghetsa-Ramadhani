<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserModel extends Model
{

   // ============================
   // | JOBSHEET 4 - PRAKTIKUM 1 |
   // ============================
   use HasFactory;

   protected $table = 'm_user'; // mendifinisikan nama tabel yang digunakan oleh model ini
   protected $primaryKey = 'user_id'; // mendefinisikan primary key dari tabel yang digunakan

   protected $hidden = ['password'];
   protected $casts = ['password' => 'hashed'];

   // ============================
   // | JOBSHEET 4 - PRAKTIKUM 2 |
   // ============================
   //  protected $fillable = ['level_id', 'username', 'nama'];
   protected $fillable = ['username', 'nama', 'password', 'level_id'];

   // Relasi ke tabel level
   public function level(): BelongsTo
   {
      return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
   }
}