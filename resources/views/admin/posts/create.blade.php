@extends('layouts.app')

@section('content')
    <form action="{{route('posts.store')}}" method="POST">
        @csrf
        @method('POST')
        <div class="form-group">
            <label for="title">Titolo</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="titolo">
        </div>
        <div class="form-group">
            <label for="body">Testo</label>
            <textarea class="form-control" id="body" name="body" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Invia</button>
    </form>
@endsection