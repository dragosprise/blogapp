<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::with('tags', 'category')->latest()->simplePaginate(10);

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }

    public function show($id): View
    {
        $post = Post::with('tags', 'user')->findOrFail($id);

        return view('posts.show', [
            'post' => $post,
        ]);
    }
    public function storeComment(Request $request, Post $post)
    {
        $request->validate([
            'body' => 'required|min:3|max:1000'
        ]);

        auth()->user()->comments()->create([
            'post_id' => $post->id,
            'body' => $request->body
        ]);

        return redirect()->route('posts.show', $post->id)

            ->with('success', 'Comentariu adăugat!');
    }
}
