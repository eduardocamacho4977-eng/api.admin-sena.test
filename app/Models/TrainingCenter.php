<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingCenter extends Model
{
    use HasFactory;

    protected $fillable = [
         'name', 
         'location',
         'imagen_url',
         'imagen_public_id',
    ];

    protected $guarded =[
    'urlFoto'
   ];


    public function areas(){
        return $this->hasMany('App\Models\Area');
    }

    public function courses(){
        return $this->hasMany('App\Models\Course');
    }

    public function teachers(){
        return $this->hasMany('App\Models\Teacher');
    }
}