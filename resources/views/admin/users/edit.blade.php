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
        <form action="{{route('users.update', $user->id)}}" method="POST" >
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="name" class="form-control" id="name" name="name" value="{{($errors->any()) ? old('name') : $user->name}}">
            </div>
            <div class="form-group">
                <label for="body">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{($errors->any()) ? old('email') : $user->email}}">
            </div>
            <div class="form-group">
                <label for="role_id">Ruolo</label>
                <select name="role_id" id="role_id">
                        <option value="{{($errors->any()) ? old('role_id') : $user->role->role}}">{{($errors->any()) ? old('role_id') : $user->role->role}}</option>
                    @foreach ($roles as $role)
                        @if ($errors->any())
                            @if ($role->role != old('role_id'))
                            <option value="{{$role->role}}">{{$role->role}}</option>
                            @endif 
                        @else
                            @if ($role->role != $user->role->role)
                            <option value="{{$role->role}}">{{$role->role}}</option>
                            @endif
                        @endif
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Invia</button>
        </form>
    </div>
@endsection