<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    use HasFactory;

    public function programs()
    {
        return $this->belongsToMany(Program::class);
    }

    public function courses()
    {
        return $this->hasOne(Course::class);
    }

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description'
    ];
}
