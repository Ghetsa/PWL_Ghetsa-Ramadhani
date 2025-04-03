<?php

namespace App\Models;

use App\Models\LevelModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 
use Illuminate\Foundation\Auth\User as Authenticatable; // implementasi class Authenticatable


class UserModel extends Authenticatable 
{
    use HasFactory;
    
    protected $table = 'm_user';
    protected $primaryKey = 'user_id';
    protected $fillable = ['username', 'nama', 'password', 'level_id', 'created_at', 'updated_at'];
    protected $hidden = ['password']; // jangan ditampilkan saat select

    protected $casts = ['password' => 'hashed']; //casting password agar otomatis di hash
    
    // protected $fillable = ['level_id', 'username', 'nama'];
    //Praktikum 2.7 langkah 1
    public function level(): BelongsTo {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    } 


    
}