<?php


namespace App\Services;


class LinkImportService
{
    public function import(int $projectId, int $userId, array $links)
    {
        dd(['links' => $links]);
    }
}