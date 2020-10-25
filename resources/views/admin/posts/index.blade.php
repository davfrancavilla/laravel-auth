@extends('layouts.app')

@section('content')
    
    <div class="container">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        
        <table class="table">
        <thead>
            <tr>
            <th scope="col">Titolo</th>
            <th scope="col">Pubblico</th>
            <th scope="col">Modifica</th>
            <th scope="col">Cancella</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr>
                <td><a href="{{route('guests.posts.show', $post->slug)}}">{{$post->title}}</a></td>
                <td><input type="checkbox" id="public" name="public" value="1" {{$post->public ? 'checked' : ''}}></td>
                <td><a href="{{route('posts.edit', $post->id)}}" class="btn btn-warning">Modifica</a></td>
                <td>
                    <form action="{{route('posts.destroy', $post->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Elimina</button>
                    </form>
                </td>
                </tr>
            @endforeach
        </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{$posts->links()}}
        </div>
    </div>
    
@endsection