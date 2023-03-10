<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'name',
        'video',
        'modul',
    ];

    public $timestamps = false;

    public function courses()
    {
        return $this->belongsTo(Course::class);
    }
}
