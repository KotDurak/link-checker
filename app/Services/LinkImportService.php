<?php


namespace App\Services;


use App\Models\Link;

class LinkImportService
{
    public function import(int $projectId, int $userId, array $links)
    {
        $data = [];

        foreach ($links as $link) {
            $data[] = [
                'project_id' => $projectId,
                'user_id'    => $userId,
                'donor_page'    => $link
            ];
        }

        Link::insert($data);
    }
}