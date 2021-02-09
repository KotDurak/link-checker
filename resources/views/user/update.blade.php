@extends('layouts.app')

@section('title', $user->name)

@section('content')
    <p>{{$user->name}} {{$user->surname}}</p>
    <span>Раздел в разработке</span>
@endsection