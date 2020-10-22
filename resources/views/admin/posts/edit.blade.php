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
        <form action="{{route('posts.update', $post->id)}}" method="POST">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label for="title">Titolo</label>
                <input type="text" class="form-control" id="title" name="title" value="{{($errors->any()) ? old('title') : $post->title}}">
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
            <button type="submit" class="btn btn-primary">Invia</button>
        </form>
    </div>
@endsection