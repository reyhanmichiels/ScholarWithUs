<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public function discussions()
    {
        return $this->hasMany(Discussion::class);
    }

    public $timestamps = false;
}
