@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card-deck">
            <div class="row">
            @foreach ($posts as $post)
                <div class="col-sm-4">
                    <div class="card m-3">
                        <img class="card-img-top" src="{{Storage::url($post->img)}}" alt="{{$post->slug}}">
                        <div class="card-body">
                            <h5 class="card-title">{{$post->title}}</h5>
                            <p class="card-text">{{Str::substr($post->body, 0, 100)."..."}}</p>
                            <p class="card-text"><small class="text-muted">{{$post->user->name}}</small></p>
                            <a href="{{route('guests.posts.show', $post->slug)}}" class="btn btn-primary">Dettagli</a>
                        </div>
                    </div>
                </div>    
            @endforeach
            </div>
        </div>
    </div>
@endsection