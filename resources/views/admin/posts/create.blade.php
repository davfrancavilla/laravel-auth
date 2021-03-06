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
        <form action="{{route('posts.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="title">Titolo</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Titolo" value="{{old('title')}}">
            </div>
            <div class="form-group">
                <label for="img">Immagine</label>
                <input type="file" class="form-control-file" id="img" name="img" accept="image/*">
            </div>
            <div class="form-group">
                <label for="body">Testo</label>
                <textarea class="form-control" id="body" name="body" rows="3" placeholder="Testo">{{old('body')}}</textarea>
            </div>
            <div class="form-group">
                @foreach ($tags as $tag)
                    <label for="{{$tag->name}}">{{$tag->name}}</label>
                    <input type="checkbox" name="tags[{{ $tag->id }}]" value="{{$tag->id}}" id="{{$tag->name}}"
                        @if (is_array(old('tags')) && in_array($tag->id, array_keys(old('tags'))))
                            checked
                        @endif
                    >
                @endforeach
            </div>
            <div class="form-group">
                <label for="public">Rendere il post pubblico?</label>
                <input type="checkbox" id="public" name="public" value="1"
                @if (old('public'))
                    checked
                @endif>
            </div>
            <button type="submit" class="btn btn-primary">Invia</button>
        </form>
    </div>
@endsection