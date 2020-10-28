@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="">
            <div class="card m-3">
                <div class="card-body">
                    <h5 class="card-title">Nome: {{$user->name}}</h5>
                    <p class="card-text">Email: {{$user->email}}</p>
                    <p class="card-text">Ruolo: <small class="text-muted">{{$user->role->role}}</small></p>
                        <a href="{{route('users.edit', $user->id)}}" class="btn btn-warning">Modifica</a>
                        <form style="display: inline" action="{{route('users.destroy', $user->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Elimina</button>
                        </form>
                </div>
            </div>
        </div> 
    </div>
</div>
@endsection