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
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col">Ruolo</th>
                <th scope="col">Modifica</th>
                <th scope="col">Cancella</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                    <td><a href="{{route('users.show', $user->id)}}">{{$user->name}}</a></td>
                    <td>{{$user->email}}</a></td>
                    <td>{{$user->role->role}}</a></td>
                    <td><a href="{{route('users.edit', $user->id)}}" class="btn btn-warning">Modifica</a></td>
                    <td>
                        <form action="{{route('users.destroy', $user->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Elimina</button>
                        </form>
                    </td>
                    </tr>
                @endforeach
            </tbody>
            </table>
        </div> 
@endsection