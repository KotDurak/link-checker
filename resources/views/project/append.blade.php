@extends('layouts.app')

@section('title', 'Назначить сотрудника')

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

    <form method="post" action="{{route('user.save-project', ['project' => $project])}}">
        @csrf
        <div class="form-group">
            <label for="exampleFormControlSelect1">Сотрудник</label>
            <select name="user_id" class="form-control" id="exampleFormControlSelect1">
                @foreach($users as $user)
                    <option value="{{$user['id']}}">{{$user['name']}} {{$user['surname']}} - ({{$user['email']}})</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary mb-2">Назначить</button>
    </form>
@endsection