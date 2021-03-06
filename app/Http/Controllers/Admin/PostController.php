<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PostController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        if(Auth::user()->role->role == 'admin'){
            $posts = Post::paginate(5);
        } elseif (Auth::user()->role->role == 'user'){
            $posts = Post::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(2);
        }
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
        $request->validate([
            'title'=>'unique:posts,title|required|min:5|max:100',
            'body'=>'required|min:5|max:500',
            'image' => 'image',
        ]);
        $data['user_id'] = Auth::id();
        $data['slug'] = Str::slug($data['title'], '-');
        $newPost = new Post();

        if(!empty($data['img'])){
            $data['img'] = Storage::disk('public')->put('images', $data['img']);
        }


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
        $request->validate([
            'title' => [
                        'required', 'min:5', 'max:100',
                        Rule::unique('posts')->ignore($post->id),
            ],
            'body'=>'required|min:5|max:500'
        ]);
        $data['slug'] = Str::slug($data['title'], '-');
        $data['updated_at'] = Carbon::now('Europe/Rome');

        if(array_key_exists("tags",$data)){
            $post->tags()->sync($data['tags']);
        } else {
            $post->tags()->detach();
        }

        if(!array_key_exists("public",$data)){
            $data['public'] = 0; 
        }



        if(!empty($data['img'])){
            if (!empty($post->img)){
                Storage::disk('public')->delete($post->img);  //cancella l'immagine nella cartella delle immagini
            }
            $data['img'] = Storage::disk('public')->put('images', $data['img']);
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
        if((request()->headers->get('referer')) == route('posts.index') || (request()->headers->get('referer')) == route('guests.posts.show', $post->slug)){
            return redirect()->route('posts.index')->with('status', 'Post'.' '.'"'.$post->title.'"'.' '.'cancellato correttamente');
        } else {
            return redirect()->route('guests.posts.home')->with('status', 'Post'.' '.'"'.$post->title.'"'.' '.'cancellato correttamente');
        }
    }
}
