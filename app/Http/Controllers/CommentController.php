<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Post $post)
    {
        return response()->json($post->comments()->paginate(5));
    }

    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'author' => 'required|string|max:100',
            'body' => 'required|string',
        ]);

        $comment = $post->comments()->create($validated);
        return response()->json($comment, 201);
    }
}
