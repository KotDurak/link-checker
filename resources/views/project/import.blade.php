@extends('layouts.app')

@section('title', 'Импорт ссылок')

@section('content')
    <form action="{{route('project.link-store', [$project_id, $user_id])}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleFormControlFile1">Файл</label>
            <input name="links" type="file" class="form-control-file" id="exampleFormControlFile1">
        </div>
        <button type="submit" class="btn btn-primary mb-2">Импорт</button>
    </form>
@endsection