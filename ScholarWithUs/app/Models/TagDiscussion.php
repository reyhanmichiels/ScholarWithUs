<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagDiscussion extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function discussions()
    {
        return $this->belongsToMany(Discussion::class);
    }
}
