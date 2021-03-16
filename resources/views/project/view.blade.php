@extends('layouts.app')

@section('title', $project->name)

@section('content')
    <h1>{{$project->name}}</h1>

    @include('project.includes.statistic', ['statistic' => $statistic])

    <div class="row">
        <div class="col-md-12">
            <p class="users-header">Сотрудники назначенные
                @if (Gate::allows('admin'))
                    <span class="add-user"><a  href="{{route('user.append', ['project' => $project])}}">+</a></span>
                @endif
            </p>
            <ul class="list-group">
                @foreach($users as $user)
                    <li class="list-group-item">
                        <a href="{{route('project.user-links', ['project' => $project, 'user' => $user])}}">
                            {{$user->getFullName()}}
                        </a>
                        @include('project.buttons', ['user' => $user, 'project' => $project])
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection