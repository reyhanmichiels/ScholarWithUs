<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function getOpenRegistrationAttribute($value)
    {
        return Carbon::parse($value)->format('d m Y');
    }

    public function getCloseRegistrationAttribute($value)
    {
        return Carbon::parse($value)->format('d m Y');
    }
}
