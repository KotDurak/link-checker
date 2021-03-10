<?php

namespace App\Exports;

use App\Models\Link;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LinkExport implements FromCollection, WithMapping, WithHeadings
{
    private $projectId;
    private $userId;
    private $rowNumber = 1;

    public function __construct(int $projectId, int $userId)
    {
        $this->projectId = $projectId;
        $this->userId = $userId;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Link::where(['project_id' => $this->projectId, 'user_id' => $this->userId])->get();
    }

    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($row): array
    {
        return [
            $this->rowNumber++,
            $row->donor_page,
            $row->target_url,
            $row->anchor,
            $row->link_status,
            $row->type,
            $row->rel_nofollow,
            $row->rel_sponsored,
            $row->rel_ugc,
            $row->content_noindex,
            $row->content_nofollow,
            $row->content_none,
            $row->content_noarchive,
            $row->noindex,
            $row->redirect_donor_page,
            $row->redirect_target_url,
            $row->updated_at
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            '#',
            'donor_page',
            'target_url',
            'anchor',
            'link_status',
            'type',
            'rel_nofollow',
            'rel_sponsored',
            'rel_ugc',
            'content_noindex',
            'content_nofollow',
            'content_none',
            'content_noarchive',
            'noindex',
            'redirect_donor_page',
            'redirect_target_url',
            'updated'
        ];
    }
}
