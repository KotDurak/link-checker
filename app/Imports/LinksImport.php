<?php

namespace App\Imports;

use App\Services\LinkImportService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class LinksImport implements ToCollection
{
    const HEADER_NAME = 'donor_page';

    private $linkImportService;
    private $projectId;
    private $userId;

    public function __construct(LinkImportService $linkImportService, int $projectId, int $userId)
    {
        $this->linkImportService = $linkImportService;
        $this->projectId = $projectId;
        $this->userId = $userId;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $links =  $collection->filter(function($item) {
            return filter_var($item[0], FILTER_VALIDATE_URL);
        })->pluck(0)->unique()->toArray();

        if (!empty($links)) {
            $this->linkImportService->import($this->projectId, $this->userId, $links);
        }
    }
}
