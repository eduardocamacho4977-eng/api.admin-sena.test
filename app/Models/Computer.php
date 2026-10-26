<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Computer extends Model
{
    use HasFactory;

    protected $fillable = [
       'number',
       'brand',
       'imagen_url',
       'imagen_public_id',
    ];

    protected $guarded =[
    'urlFoto'
   ];


    public function apprentices(){
        return $this->hasMany('App\Models\Apprentice');
    }
}