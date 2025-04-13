<?php
 
 namespace App\Models;
 
 use Illuminate\Database\Eloquent\Factories\HasFactory;
 use Illuminate\Database\Eloquent\Model;
 
 class UserModel extends Model
 {
   
    // ============================
    // | JOBSHEET 4 - PRAKTIKUM 1 |
    // ============================
    use HasFactory;
 
    protected $table = 'm_user'; // mendifinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'user_id'; // mendefinisikan primary key dari tabel yang digunakan

    
    // ============================
    // | JOBSHEET 4 - PRAKTIKUM 1 |
    // ============================
    protected $fillable = ['level_id', 'username', 'nama'];
 }