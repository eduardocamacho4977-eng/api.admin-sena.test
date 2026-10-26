<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apprentice extends Model
{
    use HasFactory;

   protected $fillable = [
        'name',
        'email',
        'cell_number',
        'course_id',
        'computer_id',
        'imagen_url',
        'imagen_public_id',
    ];

    protected $guarded =[
    'urlFoto'
   ];


    public function course(){
        return $this->belongsTo('App\Models\Course');
    }

    public function computer(){
        return $this->belongsTo('App\Models\Computer');
    }
}