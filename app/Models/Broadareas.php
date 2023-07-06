<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Broadareas extends Model
{
    use HasFactory;
    protected $fillable = [
        'id','broadarea'
    ];
}
