<?php

namespace App\Services\Parsers;



class HtmlParser
{
    private $findUrl;
    private $document;
    private $domElems = [];

    public function __construct(string $html, string $findUrl)
    {
        $this->findUrl = $findUrl;
        $this->document = new \DOMDocument() ;
        @$this->document->loadHTML($html);
        $this->initTags();
    }

    public function doParse(): array
    {
        $result = [];

        return $result;
    }

    private function initTags()
    {
        $domElems =  collect($this->document->getElementsByTagName('a'));
        $projectHost = parse_url($this->findUrl)['host'];

        $links = $domElems->filter(function ($link) use ($projectHost) {
            $href = $link->getAttribute('href');

            if (empty($href)) {
                return false;
            }

            $data = parse_url($href);

            if (empty($data['host'])) {
                return false;
            }

            return $data['host'] === $projectHost;
        });

        $elems = $links->toArray();

        foreach ($elems as $elem) {
            $href = $elem->getAttribute('href');
            $this->domElems[$href] = $elem;
        }
    }


    public function getAllRelevantLinks(): array
    {
       $result  = [];

        foreach ($this->domElems as $domElem) {
            $result[] = $domElem->getAttribute('href');
        }

        return $result;
    }

    public function getAnchor(string $url): string
    {
        foreach($this->domElems as $elem) {
            $href = $elem->getAttribute('href');

            if ($href === $url) {
               return $elem->textContent;
            }
        }

        return '';
    }

    public function getLinkType(string $url)
    {
        $elem = $this->domElems[$url];

        if ($elem->hasChildNodes()  /*&& $elem->firstChild->tagName === 'img' */) {
            $child =  $elem->childNodes[0];

            if ($child instanceof \DOMText) {
                return 'html';
            }

            if ($child instanceof  \DOMElement) {
                return 'img';
            }
        }

        return 'html';
    }

    public function getRelAttributes(string $url): array
    {
        $result = [
            'nofollow'  => 0,
            'sponsored' => 0,
            'ugc'       => 0
        ];

        $elem = $this->domElems[$url];

        if (!$elem->hasAttribute('rel')) {
            return $result;
        }

        $rels = $elem->getAttribute('rel');
        $relArr = explode(' ', $rels);

        foreach ($relArr as $rel) {
            if (array_key_exists($rel, $result)) {
                $result[$rel] = 1;
            }
        }

        return $result;
    }

    public function getMetaAttributes(string $url): array
    {
        $result = [
            'noindex' => 0,
            'nofollow' => 0,
            'none' => 0,
            'noarchive' => 0
        ];

        $metaTags = $this->document->getElementsByTagName('meta');

        foreach ($metaTags as $metaTag) {
            $name = $metaTag->getAttribute('name');

            if ($name !== 'robots') {
                continue;
            }

            $content = $metaTag->getAttribute('content');
            $collectArr = collect(explode(',', $content));

            $collectArr->each(function($val) use (&$result) {
                $metaVal = trim($val);
                if (array_key_exists($metaVal, $result)) {
                    $result[$metaVal] = 1;
                }
            });
        }

        return $result;
    }

    public function hasParentNoIndex(string $url): bool
    {
        $elem = $this->domElems[$url];
        $parentNode = $elem->parentNode;
        do {
             if($parentNode->tagName === 'noindex') {
                 return true;
             }

            $parentNode = $parentNode->parentNode;

        } while (!$parentNode instanceof \DOMDocument);

        return false;
    }
}