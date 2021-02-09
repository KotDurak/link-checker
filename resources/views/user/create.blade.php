@extends('layouts.app')

@section('title', 'Добавить сотрудника')

@section('sidebar')
    @parent
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="post" action="{{route('user.store')}}">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">Имя</label>
            <input type="text" name="name" class="form-control" id="name" aria-describedby="emailHelp" >
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">Фамилия</label>
            <input type="text" name="surname" class="form-control" id="surname" aria-describedby="emailHelp">


        <div class="form-group">
            <label for="exampleInputPassword1">Пароль</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1" >
        </div>

        <div class="form-group">
            <label for="exampleInputPassword1">Подтвердите пароль</label>
            <input type="password" name="password_confirmation" class="form-control" id="confirm_password">
        </div>

        <button type="submit" class="btn btn-primary">Создать</button>
    </form>
@endsection