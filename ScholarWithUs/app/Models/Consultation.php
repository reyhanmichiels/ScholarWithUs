<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function programs()
    {
        return $this->belongsTo(Program::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('d m Y');
    }

    public function getStartAttribute($value)
    {
        return Carbon::parse($value)->format('h:m');
    }

    public function getFinishAttribute($value)
    {
        return Carbon::parse($value)->format('h:m');
    }
}
