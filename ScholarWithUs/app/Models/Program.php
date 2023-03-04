<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'scholarship',
        'description',
        'price'
    ];

    public function scholarships()
    {
        return $this->belongsTo(Scholarship::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
