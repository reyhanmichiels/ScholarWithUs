<?php

namespace App\Http\Controllers;

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
