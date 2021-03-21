<?php


namespace App\Services;


use App\Models\Link;
use App\Models\Project;
use App\Services\Parsers\HtmlParser;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;

class CheckService
{
    private $client;
    private $checkResponseService;

    public function __construct(Client $client, CheckResponseService $checkResponseService)
    {
        $this->client = $client;
        $this->checkResponseService = $checkResponseService;
    }

    public function doCheck()
    {
        $link = $this->getActuallyLink();

        if (!$link) {
            return;
        }

        $response = $this->getResponse($link);

        if (empty($response)) {
            return;
        }

        $html = $response->getBody()->getContents();
        $parser = new HtmlParser($html, $link->project->name);
        $links = $parser->getAllRelevantLinks();

        if (empty($links)) {
            $this->setLinkFailed($link);
            return;
        }

        $this->setTargetUrlToLink($link, $links);

        if (empty($link->target_url)) {
            $link->delete();
            return;
        }

        if ($this->isIncorrectTargetUrl($link)) {
            $link->delete();
            return;
            $text = sprintf('Ссылка была удена с проекта [%s], так как ее donor_page = [%s]',
                $link->project->name, $link->donor_page);
            Log::warning($text);
        }

        $this->addNewLinks($links, $link);
        $link->anchor = $parser->getAnchor($link->target_url);
        $link->link_status = 1;
        $link->type = $parser->getLinkType($link->target_url);
        $this->setRelAttributes($link, $parser);
        $this->setMetaAttributes($link, $parser);
        $link->noindex = $parser->hasParentNoIndex($link->target_url);
        $link->redirect_donor_page = $this->checkResponseService->isRedirect($response);
        $this->setRedirectTargetUrl($link);
        $link->setUpdatedAt($link->freshTimestampString());
        $link->save();

        Log::info(sprintf('Ссылка [%s]  успешно проверена для проекта [%s]', $link->donor_page, $link->project->name));
    }

    private function getActuallyLink(): ?Link
    {
        return Link::orderBy('updated_at', 'asc')
            ->with('project')
            ->limit(1)->first();
    }

    /**
     * @param string $donorPage
     * @return ResponseInterface
     */
    private function getResponse(Link $link)
    {
        try {
            $response = $this->client->request('GET', $link->donor_page);

            return $response;

        }catch (ClientException $ex) {
            if ($ex->getCode() == 404) {
                $this->setLinkFailed($link);
            }
        } catch (\Exception $ex) {
            $this->setLinkFailed($link);
        }
    }

    private function setRedirectTargetUrl(Link $link)
    {
        try {

            $response = $this->client->request('GET', $link->target_url);
            if ($this->checkResponseService->isRedirect($response)) {
                $link->redirect_target_url = 1;
            }

        } catch (ClientException $ex) {
            $link->redirect_target_url = 0;
        } catch (\Exception $ex) {
            $this->setLinkFailed($link);
        }
    }

    private function setLinkFailed(Link $link)
    {

        $link->link_status = 0;
        $time =   $link->freshTimestampString();
        $link->setUpdatedAt($time);
        $link->save();
    }

    private function setTargetUrlToLink(Link $link, array $urls)
    {
        if (empty($link->target_url)) {
            foreach ($urls as $url) {
                if (!$this->checkLinkExists($link->project_id, $url, $link->donor_page)) {
                    $link->target_url = $url;
                    break;
                }
            }
        }
    }

    private function addNewLinks(array $urls, Link $link)
    {
        collect($urls)->reject(function($url) use ($link){
            return $url == $link->target_url;
        })->each(function($url) use ($link) {
            $this->createLinkIfNotExists($link, $url);
        });
    }

    private function createLinkIfNotExists(Link $oldLink, string $targetUrl)
    {

        if ($this->checkLinkExists($oldLink->project_id, $targetUrl, $oldLink->donor_page)) {
            return;
        }

        $link = new Link();
        $link->donor_page = $oldLink->donor_page;
        $link->target_url = $targetUrl;
        $link->project_id = $oldLink->project_id;
        $link->user_id = $oldLink->user_id;
        $link->save();
    }

    private function checkLinkExists(int $projectId, string  $url, string $donorPage): bool
    {
        $freeLink = Link::where([
            'target_url' => $url,
            'project_id' => $projectId,
            'donor_page' => $donorPage
        ])->first();

        return !empty($freeLink);
    }

    private function setRelAttributes(Link $link, HtmlParser $parser)
    {
        $rels = $parser->getRelAttributes($link->target_url);

        $link->rel_nofollow = Arr::get($rels, 'nofollow', 0);
        $link->rel_sponsored = Arr::get($rels, 'sponsored', 0);
        $link->rel_ugc = Arr::get($rels, 'ugc', 0);
    }

    private function setMetaAttributes(Link $link, HtmlParser $parser)
    {
        $attributes = $parser->getMetaAttributes($link->target_url);
        $link->content_noindex  = Arr::get($attributes, 'noindex', 0);
        $link->content_nofollow = Arr::get($attributes, 'nofollow', 0);
        $link->content_none = Arr::get($attributes, 'none', 0);
        $link->content_noarchive = Arr::get($attributes, 'noarchive', 0);
    }

    private function isIncorrectTargetUrl(Link $link): bool
    {
        $findHost = $this->getHost($link->project->name);
        $donorHost = $this->getHost($link->target_url);

        return $findHost != $donorHost;
    }

    private function getHost(string $url): string
    {
        return Arr::get(parse_url($url), 'host', '');
    }

}