<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function student_assessments()
    {
        return $this->hasMany(StudentAssessment::class);
    }
    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function class(){
        return $this->belongsTo(Classes::class);
    }

    public function status(){
        return $this->belongsTo(Status::class);
    }

    public function getByName($name)
    {
        return $this->whereRaw('LOWER(TRIM(name)) = ?', [strtolower(trim($name))])->first();
    }
}
