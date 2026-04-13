<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(): View
    {
        $featuredPost = Post::with('tags', 'category')->latest()->first();

        $postsQuery = Post::with('tags', 'category')->latest();
        if ($featuredPost) {
            $postsQuery->whereKeyNot($featuredPost->getKey());
        }

        $posts = $postsQuery->simplePaginate(10);

        $trendingPosts = Post::with('category')->latest()->take(5)->get();

        $categories = Category::query()
            ->withCount('posts')
            ->orderByDesc('posts_count')
            ->take(8)
            ->get();

        $tags = Tag::query()
            ->withCount('posts')
            ->orderByDesc('posts_count')
            ->take(10)
            ->get();

        return view('posts.index', [
            'posts' => $posts,
            'featuredPost' => $featuredPost,
            'trendingPosts' => $trendingPosts,
            'categories' => $categories,
            'tags' => $tags,
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
