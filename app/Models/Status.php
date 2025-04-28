<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function getByName($statusName)
{
    return $this->whereRaw('LOWER(TRIM(status_name)) = ?', [strtolower(trim($statusName))])
                ->first();
}

}
