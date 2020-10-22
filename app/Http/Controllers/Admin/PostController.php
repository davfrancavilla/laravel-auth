<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class PostController extends Controller
{

    protected $validation = [
        'title'=>'required|min:5|max:100',
        'body'=>'required|min:5|max:500'
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('admin.posts.index', compact('posts'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $tags = Tag::all();
        return view('admin.posts.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        
        $request->validate($this->validation);
        $data['user_id'] = Auth::id();
        $data['slug'] = Str::slug($data['title'], '-');
        $newPost = new Post();
        $newPost->fill($data);
        
        $saved = $newPost->save();

        
        if(array_key_exists("tags",$data)){
            $newPost->tags()->attach($data['tags']);
        }

        if ($saved) {
            return redirect()->route('posts.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $tags = Tag::all();
        return view('admin.posts.edit', compact('post', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {

        $data = $request->all(); //data diventa array di dati
        $request->validate($this->validation);
        $data['slug'] = Str::slug($data['title'], '-');
        $data['updated_at'] = Carbon::now();

        if((array_key_exists("tags",$data))){
            $newPost->tags()->attach($data['tags']);
        }

        $post->update($data);
        return redirect()->route('posts.index')->with('status', 'Post'.' '.'"'.$post->title.'"'.' '.'salvato correttamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('status', 'Post'.' '.'"'.$post->title.'"'.' '.'cancellato correttamente');
    }
}
