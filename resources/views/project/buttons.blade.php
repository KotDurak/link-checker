@can('admin')
<form method="post"
      action="{{route('project.detach-user', ['project_id' => $project->id, 'user_id' => $user->id])}}"
      class="delete-form"
    >
    @csrf
    <button class="btn">
        <i class="fa fa-remove"></i>
    </button>
</form>
@endcan
@can('link.import', $user->id)
    <a href="{{route('project.link-import', [$project->id, $user->id])}}">
        <i class="fa fa-arrow-up"></i>
    </a>

    <a href="{{route('project.link-export', [$project->id, $user->id])}}">
        <i class="fa fa-arrow-down"></i>
    </a>
@endcan