@extends('layouts.links-table')

@section('title', 'Ссылки пользователя ' . $user->getFullName())

@section('content')
    <div class="col-md-12">
        <p>
            <a href="{{route('project.view', $project)}}">{{$project->name}}</a>
        </p>

        <p>Сотрудник: <b>{{$user->getFullName()}}</b></p>
    </div>

   @include('project.includes.filter')

    <div class="col-md-12">
        <p>Найдено записей {{$count}}</p>
    </div>

    <div class="table-container fixed-table">
        <table class="table table-bordered">
            <thead class="fixed-header">
            <tr>
                <th scope="col" width="100">Donor page</th>
                <th scope="col">Target url</th>
                <th scope="col">Anchor</th>
                <th scope="col">Link status</th>
                <th scope="col">Type</th>
                <th scope="col">Rel<br/>"nofollow"</th>
                <th scope="col">Rel<br/>"sponsored"</th>
                <th scope="col">Rel<br/>"UGC"</th>
                <th scope="col">content<br/>"noindex"</th>
                <th scope="col">content<br/>"nofollow"</th>
                <th scope="col">content<br/>"none"</th>
                <th scope="col">content<br/>"noarchive"</th>
                <th scope="col">noindex</th>
                <th scope="col">redirect donor page</th>
                <th scope="col">redirect target url</th>
                <th scope="col">Дата последней проврки</th>
            </tr>
            </thead>
            <tbody>
            @foreach($links as $link)
                <tr>
                    <td  width="100" class="fixed-column">
                        <a href="{{$link->donor_page}}">
                            {{$link->donor_page}}
                        </a>
                    </td>
                    <td class="fixed-column">
                        <a href="{{$link->target_url}}">
                            {{$link->target_url}}
                        </a>
                    </td>
                    <td class="fixed-column">
                        <span>{{$link->anchor}}</span>
                    </td>
                    <td>
                        {{$link->link_status}}
                    </td>
                    <td>
                        {{$link->type}}
                    </td>
                    <td>
                        {{$link->rel_nofollow}}
                    </td>
                    <td>
                        {{$link->rel_sponsored}}
                    </td>
                    <td>
                        {{$link->rel_ugc}}
                    </td>
                    <td>
                        {{$link->content_noindex}}
                    </td>
                    <td>
                        {{$link->content_nofollow}}
                    </td>
                    <td>
                        {{$link->content_none}}
                    </td>
                    <td>
                        {{$link->content_noarchive}}
                    </td>
                    <td>
                        {{$link->noindex}}
                    </td>
                    <td>
                        {{$link->redirect_donor_page}}
                    </td>
                    <td>
                        {{$link->redirect_target_url}}
                    </td>
                    <td>
                        {{$link->updated_at}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{$links->appends($nextQuery)->links()}}
@endsection