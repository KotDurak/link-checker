@extends('layouts.app')

@section('title', $project->name)

@section('content')
    <h1>{{$project->name}}</h1>
@endsection