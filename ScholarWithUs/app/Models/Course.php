<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function programs()
    {
        return $this->belongsToMany(Program::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    // public function mentor()
    // {
    //     return $this->belongsTo(Mentor::class);
    // }

    public function userProgresses()
    {
        return $this->hasMany(UserProgress::class);
    }

    public $timestamps = false;

}
