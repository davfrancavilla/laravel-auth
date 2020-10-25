@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <div class="card-deck">
            <div class="row">
            @foreach ($posts as $post)
                @if($post->public)
                    <div class="col-sm-4">
                        <div class="card m-3">
                            @if ($post->img)
                            <img class="card-img-top" src="{{Storage::url($post->img)}}" alt="{{$post->slug}}">  {{-- oppure asset('storage/').$post->img per il percorso dell'immagine --}}
                            @endif
                            <div class="card-body">
                                <h5 class="card-title"><a href="{{route('guests.posts.show', $post->slug)}}">{{$post->title}}</a></h5>
                                <p class="card-text">{{Str::substr($post->body, 0, 100)."..."}}</p>
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
                @endif
            @endforeach
            </div>
        </div>
    </div>
@endsection