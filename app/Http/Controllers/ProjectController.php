<?php

namespace App\Http\Controllers;

use App\Exports\LinkExport;
use App\Imports\LinksImport;
use App\Models\Link;
use App\Models\Project;
use App\Services\LinkImportService;
use App\Services\LinkStatisticService;
use App\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class ProjectController extends Controller
{
    private $linkStatisticService;

    public function __construct(LinkStatisticService $linkStatisticService)
    {
        $this->linkStatisticService = $linkStatisticService;
    }

    public function view(Project $project)
    {
        $users = $project->users;

        $statistic = $this->linkStatisticService->getStatByProject($project->id);

        return view('project.view', [
            'project' => $project,
            'users'   => $users,
            'statistic' => $statistic
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
            $path1 = $request->file('links')->store('temp');
            $path = storage_path('app').'/'.$path1;
           // $file = $request->file('links')->getRealPath();

            \Maatwebsite\Excel\Facades\Excel::import(new LinksImport(new LinkImportService(),  $project_id, $user_id), $path);
        }

        return back();
    }

    public function linkExport(int $project_id, int $user_id)
    {
       return \Maatwebsite\Excel\Facades\Excel::download(new LinkExport($project_id, $user_id), 'link-export.xlsx');
    }

    public function addProject()
    {
        return view('project.add');
    }

    public function store(Request $request)
    {
       $validated =  $request->validate([
            'name'  => 'url|required'
        ]);

        Project::create($request->only('name'));

        return back();
    }

    public function linksDelete(Request $request)
    {
        return Link::destroy($request->post('ids'));
    }
}
