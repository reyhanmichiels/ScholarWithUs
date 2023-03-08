<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory, HasUuids;

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function programs()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public $timestamps = false;
}
