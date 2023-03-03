<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    public function discussions()
    {
        return $this->belongsTo(Discussion::class);
    }

    public $timestamps = false;
}
