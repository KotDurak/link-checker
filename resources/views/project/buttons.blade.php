<form method="post"
      action="{{route('project.detach-user', ['project_id' => $project->id, 'user_id' => $user->id])}}"
      class="delete-form"
    >
    @csrf
    <button class="btn">
        <i class="fa fa-remove"></i>
    </button>
</form>

<a href="{{route('project.link-import', [$project->id, $user->id])}}">
    <i class="fa fa-arrow-up"></i>
</a>