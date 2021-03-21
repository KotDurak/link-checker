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

        <p>
            <button class="btn btn-danger" id="remove-select">Удалить отмеченное</button>
        </p>
    </div>

    <div class="table-container fixed-table">
        <table class="table table-bordered table-sm">
            <thead class="fixed-header">
            <tr>
                <th scope="col">
                    <input type="checkbox" id="main-checkbox">
                </th>
                <th scope="col" width="100">Donor page</th>
                <th scope="col">Target url</th>
                <th scope="col">Anchor</th>
                <th scope="col">Link status</th>
                <th scope="col">Type</th>
                <th scope="col" class="bg-warning"> Rel<br/>"nofollow"</th>
                <th scope="col" class="bg-warning">Rel<br/>"sponsored"</th>
                <th scope="col" class="bg-warning">Rel<br/>"UGC"</th>
                <th scope="col" class="bg-info">content<br/>"noindex"</th>
                <th scope="col" class="bg-info">content<br/>"nofollow"</th>
                <th scope="col" class="bg-info">content<br/>"none"</th>
                <th scope="col" class="bg-info">content<br/>"noarchive"</th>
                <th scope="col" class="bg-noindex">noindex</th>
                <th scope="col" class="bg-redirect">redirect donor page</th>
                <th scope="col" class="bg-redirect">redirect target url</th>
                <th scope="col">Дата последней проврки</th>
            </tr>
            </thead>
            <tbody>
            @foreach($links as $link)
                <tr data-key="{{$link->id}}">
                    <td>
                        <input type="checkbox" value="{{$link->id}}" class="table-checkbox">
                    </td>
                    <td  width="100" class="fixed-column">
                        <p class="simple-link-text">
                            <a href="{{$link->donor_page}}" data-toggle="tooltip" data-placement="top" title="{{$link->donor_page}}">
                                {{$link->donor_page}}
                            </a>
                        </p>
                    </td>
                    <td class="fixed-column">
                        <p class="simple-link-text">
                            <a href="{{$link->target_url}}">
                                {{$link->target_url}}
                            </a>
                        </p>
                    </td>
                    <td class="fixed-column">
                        <p class="simple-link-text">
                            <span data-toggle="tooltip" data-placement="top" title="{{$link->anchor}}">
                                {{$link->anchor}}
                            </span>
                        </p>

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
                        <p class="simple-link-text">
                            <span data-toggle="tooltip" data-placement="top" title="{{$link->updated_at}}">
                                {{$link->updated_at}}
                            </span>
                        </p>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{$links->appends($nextQuery)->links()}}
@endsection