<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $dates = ['upload_date','update_date'];
    protected $fillable = [
        'id',
        'course_id',
        'name',
        'desc',
        'content',
        'upload_date',
        'update_date',
    ];
    public function ofCourse(){
        return $this->hasOne(Course::class,'id','course_id');
    }
}
