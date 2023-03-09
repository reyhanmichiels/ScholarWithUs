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

    public function mentors()
    {
        return $this->belongsTo(Mentor::class, 'mentor_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function tagCosts()
    {
        return $this->belongsTo(TagCost::class, 'tag_cost_id');
    }

    public function tagLevels()
    {
        return $this->belongsTo(TagLevel::class, 'tag_level_id');
    }
    
    public function tagCountries()
    {
        return $this->belongsToMany(TagCountry::class);
    }
}
