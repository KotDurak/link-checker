<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Project;
use App\User;
use Illuminate\Http\Request;

class LinksController extends Controller
{
    public function showLinks(Request $request, Project $project)
    {
        $users = $project->users;

        return view('project.links', [
            'project' => $project,
            'users'   => $users
        ]);
    }

    public function userLinks(Request $request, Project $project, User $user)
    {

        $query = Link::where(['project_id' => $project->id, 'user_id' => $user->id]);

        $nextQuery = [];

        if ($request->has('filter')) {
            $this->addQueryParams($query, $request->input('filter'));
            $nextQuery =  ['filter' => $request->input('filter')];
        }

        $count = $query->count();


        $links = $query->orderBy('updated_at', 'asc')
            ->paginate(100);

        $users = $project->users;

        return view('project.links-table', [
            'links' => $links,
            'user' => $user,
            'users' => $users,
            'project' => $project,
            'count' => $count,
            'nextQuery' => $nextQuery
        ]);
    }

    private function addQueryParams($query, array $params)
    {
        foreach ($params as $key => $value) {
            if (is_numeric($value)) {
                $query->where($key, $value);
            }
        }
    }
}
