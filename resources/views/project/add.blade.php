@extends('layouts.app')

@section('title', 'Добавить проект')

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
    <form method="post" action="{{route('project.store')}}">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Проект</label>
            <input type="text" class="form-control" name="name" id="name"  placeholder="Проект">
        </div>
        <button type="submit" class="btn btn-primary">Добавить</button>
    </form>
@endsection