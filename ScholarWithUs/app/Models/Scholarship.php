<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public $timestamps = false;

    public function programs()
    {
        return $this->hasOne(Program::class);
    }
    
    public function tagCosts()
    {
        return $this->belongsTo(TagCost::class);
    }

    public function tagLevels()
    {
        return $this->belongsTo(TagLevel::class);
    }
    
    public function tagCountries()
    {
        return $this->belongsToMany(TagCountry::class);
    }
}
