<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tamu extends Model
{
    use HasFactory;

    protected $table = 'tamu'; //optional untuk Laravel 9

    public $fillable = ['slug', 'nama', 'no_telp', 'alamat'];
}
