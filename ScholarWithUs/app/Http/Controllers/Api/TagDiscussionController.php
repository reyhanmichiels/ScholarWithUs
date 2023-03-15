<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TagDiscussion;
use Illuminate\Http\Request;

class TagDiscussionController extends Controller
{
    public static function store($name)
    {
        $tagDiss = TagDiscussion::where('name', $name)->get();

        if (empty($tagDiss->toArray())) {
            $tag = new TagDiscussion;
            $tag->name = strtolower($name);
            $tag->save();
            return $tag->id;
        }

        return $tagDiss->first()->id;
    }
}
