<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagArticle extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public $timestamps = false;

    public function articles()
    {
        return $this->hasMany(Article::class, 'tag_article_id');
    }
}
