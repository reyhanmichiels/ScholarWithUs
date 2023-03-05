<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagCost extends Model
{
    use HasFactory;

    public function programs()
    {
        return $this->hasMany(Program::class);
    }

    public function scholarships()
    {
        return $this->hasMany(Scholarship::class);
    }

    public $fillable = ['name'];

    public $timestamps = false;
}
