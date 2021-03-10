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

    <div class="row justify-content-center">
        <div class="col-md-8">
            <form method="post" action="{{route('password.change')}}">
                @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">Новый пароль</label>
                    <input type="password" name="password" class="form-control" id="exampleInputEmail1">
                </div>

                <button type="submit" class="btn btn-primary">Сменить пароль</button>
            </form>
        </div>
    </div>
</div>
@endsection
