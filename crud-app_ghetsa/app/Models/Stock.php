<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    // Menentukan atribut yang dapat diisi secara massal
    protected $fillable = ['name', 'description'];
}
