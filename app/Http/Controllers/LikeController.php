<?php

namespace App\Http\Controllers;

use App\Idea;
use App\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \App\Like|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $like = Like::where([
            ['idea_id', $request->idea_id],
            ['user_id', $request->user()->id],
        ])->first();

        $idea = Idea::find($request->idea_id);

        if (!$like) {
            $like = Like::create([
                'idea_id' => $request->idea_id,
                'user_id' => auth()->id(),
                'is_liked' => true,
            ]);

            $idea->is_read = false;
            $idea->update();

            return $like;
        }
        if ($like->is_liked) {
            $like->update([
                'is_liked' => false,
            ]);

            $idea->is_read = false;
            $idea->update();

            return $like;
        }

        $like->update([
            'is_liked' => true,
        ]);

        $idea->is_read = false;
        $idea->update();

        return $like;

    }
}
