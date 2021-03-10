<ul class="nav nav-tabs">
    @foreach($users as $user)
        <li class="nav-item">
            <a class="nav-link" href="{{route('project.user-links', ['project' => $project, 'user' => $user])}}">
                {{$user->getFullName()}}
            </a>
        </li>
    @endforeach
</ul>