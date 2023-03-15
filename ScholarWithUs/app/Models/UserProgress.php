<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'program_id',
        'mentor_id',
        'course_id'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function programs()
    {
        return $this->belongsTo(Program::class);
    }

    public function mentors()
    {
        return $this->belongsTo(Mentor::class);
    }

    public function courses()
    {
        return $this->belongsTo(Course::class);
    }
}
