@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="">
            <div class="card m-3">
                @if ($post->img)
                <img class="card-img-top" src="{{Storage::url($post->img)}}" alt="{{$post->slug}}">  {{-- oppure asset('storage/').$post->img per il percorso dell'immagine --}}
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{$post->title}}</h5>
                    <p class="card-text">{{$post->body}}</p>
                    <p class="card-text"><small class="text-muted">{{$post->user->name}}</small></p>
                    @if (Auth::id() == $post->user->id)
                        <a href="{{route('posts.edit', $post->id)}}" class="btn btn-warning">Modifica</a>
                        <form style="display: inline" action="{{route('posts.destroy', $post->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Elimina</button>
                        </form>
                    @endif
                </div>
            </div>
        </div> 
    </div>
</div>
     
    
@endsection