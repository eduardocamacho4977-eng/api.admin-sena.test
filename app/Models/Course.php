<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
      'course_number',
      'day',
      'area_id',
      'training_center_id',
      'imagen_url',
      'imagen_public_id',
    ];

    protected $guarded =[
     'urlFoto'
   ];


    public function area(){
        return $this->belongsTo('App\Models\Area');
    }

    public function trainingCenter(){
        return $this->belongsTo('App\Models\TrainingCenter');
    }

    public function teachers(){
        return $this->belongsToMany('App\Models\Teacher','course_teachers');
    }

    public function apprentices(){
        return $this->hasMany('App\Models\Apprentice');
    }

    protected static function booted()
    {
        static::deleting(function ($course) {
            $course->apprentices()->each(function ($apprentice) {
                $apprentice->delete();
            });
        });
    }
}