<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Http\Response;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Paginación con filtros simples
        $query = Post::query();

        if ($request->filled('title')) {
            $query->where('title', 'like', '%'.$request->title.'%');
        }

        return response()->json($query->paginate(5));
    }

    /**
     * Create a new post.
     *
     * @bodyParam title string required The title of the post.
     * @bodyParam body string required The body of the post.
     * @responseField id integer The ID of the new post.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|min:3|max:255',
            'content' => 'required',
        ]);

        $post = Post::create($validated);
        return response()->json($post, 201);
    }

    public function show(Post $post)
    {
        return response()->json($post->load('comments'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|min:3|max:255',
            'content' => 'sometimes|required',
        ]);

        $post->update($validated);
        return response()->json($post);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response()->noContent();
    }
}
