@extends('layouts.app')

@section('title', 'Пользователи')

@section('sidebar')
    @include('admin.sidebar')
@endsection

@section('content')
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">Имя</th>
            <th scope="col">E-main</th>
            <th scope="col">Админ</th>
            <th scope="col">Дата регистрации</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <th>{{$user->name . ' ' . $user->surname}}</th>
                <td>{{$user->email}}</td>
                <td>
                    @if (!$user->isAdmin())
                        <form method="post" action="{{route('admin.users.set-admin', ['user' => $user])}}">
                            @csrf
                            <button type="submit" class="btn btn-primary">Назначить</button>
                        </form>
                    @else
                        <form method="post" action="{{route('admin.users.cancel-admin', ['user' => $user])}}">
                            @csrf
                            <button type="submit" class="btn btn-danger">Снять с должности</button>
                        </form>
                    @endif
                </td>
                <td>{{$user->created_at}}</td>
                <td>
                    <form action="{{route('admin.users.delete', $user)}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $users->links() }}
@endsection