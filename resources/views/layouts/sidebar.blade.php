<h5>Проекты:
    @can('admin')
    <span class="add-user"><a href="{{route('project.add')}}">+</a></span>
    @endcan
</h5>

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
                @can('admin')
                    <form action="{{route('project.delete', [$project->id])}}" method="post" class="delete-form">
                        @csrf
                        @method('delete')
                        <button class="btn"><i class="fa fa-remove"></i></button>
                    </form>
                @endcan
            </li>
        @endforeach
    </ul>
</div>