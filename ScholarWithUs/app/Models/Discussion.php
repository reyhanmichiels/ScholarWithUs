<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function tagDiscussions()
    {
        return $this->belongsToMany(TagDiscussion::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d m Y H:i');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }

    public $timestamps = false;

}
