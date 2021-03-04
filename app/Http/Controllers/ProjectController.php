<?php

namespace App\Http\Controllers;

use App\Imports\LinksImport;
use App\Models\Project;
use App\Services\LinkImportService;
use App\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class ProjectController extends Controller
{
    public function view(Project $project)
    {
        $users = $project->users;

        return view('project.view', [
            'project' => $project,
            'users'   => $users
        ]);
    }

    public function append(Project $project)
    {


        $users = User::where(['block' => 0])
            ->orderBy('name', 'asc')
            ->whereNotIn('id', function($query) use ($project) {
                $query->select('user_id')
                ->from('user_project')
                ->where('project_id', $project->id);
            })
            ->get()
            ->toArray();

        return view('project.append', compact('users', 'project'));
    }

    public function saveUser(Request $request, Project $project)
    {
        $userId = $request->post('user_id');

        if ($project->users()->where(['users.id' => $userId])->exists()) {
            return redirect()->route('user.append', ['project' => $project])
                ->withErrors(['users' => 'Этот пользователь уже есть на проекте']);
        }

        $project->users()->attach($userId);

        return redirect()->route('project.view', ['project' => $project]);
    }

    public function delete(Request $request, $id)
    {
        Project::destroy($id);

        return back();
    }

    public function detachUser(Request $request, $project_id, $user_id)
    {
        $project = Project::findOrFail($project_id);
        $project->users()->detach($user_id);

        return back();
    }

    public function import(Request $request, int $project_id, int $user_id)
    {
        return view('project.import', [
            'project_id' => $project_id,
            'user_id'    => $user_id
        ]);
    }

    public function linkStore(Request $request, int $project_id, int $user_id)
    {
        if ($request->hasFile('links')) {
            $file = $request->file('links')->getRealPath();

            $links = \Maatwebsite\Excel\Facades\Excel::import(new LinksImport(new LinkImportService(),  $project_id, $user_id), $file);

            dd($links);
        }

        return back();
    }
}
