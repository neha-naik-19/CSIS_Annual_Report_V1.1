<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pubdtls extends Model
{
    use HasFactory;

    protected $fillable = [
        'slno','pubhdrid','athrfirstname','athrmiddlename','athrlastname','fullname','inhouseflag'
    ];

    public function Pubhdrs(){
        return $this->belongsTo('App\Pubhdrs','id');
    }
}
