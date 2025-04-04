<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 

class UserModel extends Model
{
    use HasFactory;
    protected $table = 'm_user';
    protected $primaryKey = 'user_id';

    // protected $fillable = ['level_id', 'username', 'nama'];
    protected $fillable = ['username', 'nama', 'password', 'level_id'];

    // public function level(): HasOne
    // {
    //     return $this->hasOne(LevelModel::class);
    // }

    // ------------------------------------------------
    // Praktikum 2.7 Langkah 1
    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }
}