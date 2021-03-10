<?php


namespace App\Services;


use Psr\Http\Message\ResponseInterface;

class CheckResponseService
{
    public function isRedirect(ResponseInterface $response): bool
    {
        return !empty($response->getHeader(\GuzzleHttp\RedirectMiddleware::STATUS_HISTORY_HEADER));
    }
}