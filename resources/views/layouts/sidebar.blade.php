<h5>Проекты:</h5>

<div class="project-list">
    <ul class="list-group">
        @foreach($projects as $project)
            <li class="list-group-item">
                <a href="/">{{$project->name}}</a>
            </li>
        @endforeach
    </ul>
</div>