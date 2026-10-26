<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'name',
        'imagen_url',
        'imagen_public_id',
   ];

   protected $guarded =[
    'urlFoto'
   ];



    public function courses(){
        return $this->hasMany('App\Models\Course');
    }

    public function teachers(){
        return $this->hasMany('App\Models\Teacher');
    }

    protected static function booted()
    {
        static::deleting(function ($area) {
            $area->courses()->each(function ($course) {
                $course->delete();
            });

            $area->teachers()->each(function ($teacher) {
                $teacher->delete();
            });
        });
    }
}
