@extends('layouts.app')
@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{route('posts.update', $post->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            @if ($post->img)
                <img src="{{Storage::url($post->img)}}" alt="{{$post->slug}}" width="300px">  {{-- oppure asset('storage/').$post->img per il percorso dell'immagine --}}
            @endif
            <div class="form-group">
                <label for="title">Titolo</label>
                <input type="text" class="form-control" id="title" name="title" value="{{($errors->any()) ? old('title') : $post->title}}">
            </div>
            <div class="form-group">
                <label for="img">Immagine</label>
                <input type="file" class="form-control-file" id="img" name="img" accept="image/*">
            </div>
            <div class="form-group">
                <label for="body">Testo</label>
                <textarea class="form-control" id="body" name="body" rows="3" placeholder="Testo">{{($errors->any()) ? old('body') : $post->body}}</textarea>
            </div>
            <div class="form-group">
                @foreach ($tags as $tag)
                    <label for="{{$tag->name}}">{{$tag->name}}</label>
                    <input type="checkbox" name="tags[{{ $tag->id }}]" value="{{$tag->id}}" id="{{$tag->name}}" {{($post->tags->contains($tag->id) ? 'checked' : '')}}
                        @if (is_array(old('tags')) && in_array($tag->id, array_keys(old('tags'))))
                            checked
                        @endif
                    >
                @endforeach
            </div>
            <div class="form-group">
                <label for="public">Rendere il post pubblico?</label>
                <input type="checkbox" id="public" name="public" value="1"
                {{$post->public ? 'checked' : ''}}
                @if (old('public'))
                    checked
                @endif
                >
            </div>
            <button type="submit" class="btn btn-primary">Invia</button>
        </form>
    </div>
@endsection