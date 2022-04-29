<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condidat extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'age',
        'detail',
        'image_path',
        'cv'
    ];
}
