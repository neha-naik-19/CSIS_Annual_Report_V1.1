<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pubhdrs extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','departmentID','categoryid','authortypeid','articletypeid','nationality',
        'pubdate','submitted','accepted','published','title','confname','place','rankingid','broadareaid',
        'impactfactor','description','volume','issue','pp','userid','publisher','note',
        'deleted','digitallibrary','bibtexfile','created_at','updated_at'
    ];
}
