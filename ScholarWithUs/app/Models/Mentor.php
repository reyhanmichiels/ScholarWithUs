<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    use HasFactory;

    public function programs()
    {
        return $this->hasMany(Program::class);
    }

    // public function courses()
    // {
    //     return $this->hasOne(Course::class);
    // }

    public function userProgresses()
    {
        return $this->hasMany(UserProgress::class);
    }

    protected $fillable = [
        'name',
        'study_track',
        'scholar_history'
    ];
}
