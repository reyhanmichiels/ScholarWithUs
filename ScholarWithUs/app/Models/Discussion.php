<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    use HasFactory;

    public function replies()
    {
        return $this->hasMany(Reply::class, 'discussion_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public $timestamps = false;

}
