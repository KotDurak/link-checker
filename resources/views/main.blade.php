@extends('layouts.app')

@section('title', 'Link checker')

@section('sidebar')
    @parent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <p class="users-header">Сотрудники назначенные
                @if (Gate::allows('admin'))
                    <span class="add-user"><a  href="{{route('user.create')}}">+</a></span>
                @endif
            </p>
        </div>
    </div>
@endsection