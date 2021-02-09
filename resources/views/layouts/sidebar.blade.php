<h5>Проекты:</h5>

<div class="project-list">
    <ul class="list-group">
        @foreach($projects as $project)
            <?php
                $class = '';

                $current = Request::route('project');

                if ($current instanceof \App\Models\Project && $current->id == $project->id) {
                    $class = 'active-project';
                }
            ?>

            <li class="list-group-item {{$class}}">
                <a href="{{route('project.view', [$project])}}">{{$project->name}}</a>
            </li>
        @endforeach
    </ul>
</div>