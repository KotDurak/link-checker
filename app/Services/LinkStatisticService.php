<?php


namespace App\Services;


use App\Models\Link;

class LinkStatisticService
{
    public function getStatByProject(int $projectId): array
    {

        $found = Link::where([
            'project_id' => $projectId,
            'link_status' => 1
        ])->count();

        $notFound = Link::where([
            'project_id' => $projectId,
            'link_status'   => 0
        ])->count();


        $percents = $this->percentCalculate($found, $notFound);

        return [
            'found' =>  [
                'count' => $found,
                'percent' => $percents['found']
            ],
            'not_found' => [
                'count' => $notFound,
                'percent' => $percents['not_found']
            ]
        ];
    }


    private function percentCalculate(int $found = 0, int $notFound = 0): array
    {
        $result = [
            'found' => 0,
            'not_found' => 0
        ];

        $all = $found + $notFound;

        if ($all == 0) {
            return $result;
        }

        $foundPercent =  round($found * 100 / $all);
        $notFoundPercent = round($notFound * 100 / $all);

        $result['found'] = $foundPercent;
        $result['not_found'] = $notFoundPercent;

        return $result;
    }
}