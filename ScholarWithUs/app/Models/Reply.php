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

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $fillable = [
        'user_id',
        'discussion_id',
        'comment'
    ];

    public $timestamps = false;
}
