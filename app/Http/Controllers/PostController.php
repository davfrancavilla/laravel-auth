<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(){
        $posts = Post::all();
        return view('guests.posts', compact('posts'));
    }

    public function show($slug){

        $post = Post::where('slug', $slug)->first();
        if ((!$post->public && Auth::id() == $post->user->id) || ($post->public)){
            return view('guests.show', compact('post'));
        }
        return redirect()->route('guests.posts.home');
    }
}
