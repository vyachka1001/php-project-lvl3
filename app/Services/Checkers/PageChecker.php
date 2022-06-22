<?php

namespace App\Services\Checkers;

use App\Repositories\UrlRepository;
use App\Dto\Response\UrlInfoResponse;
use Illuminate\Support\Facades\Http;
use DiDom\Document;

class PageChecker
{
    private  UrlRepository $urlRepository;

    public function __construct(UrlRepository $urlRepository)
    {
        $this->urlRepository = $urlRepository;
    }

    /**
     * Collect info about corresponding url.
     * @param int $urlId url's id
     *
     * @return UrlInfoResponse
     */
    public function getUrlInfo($urlId): UrlInfoResponse
    {
        $name = $this->urlRepository->findNameById($urlId);

        $response = Http::get($name);
        $document = new Document($response->body());

        $h1 = optional($document->first('h1'))->text();
        $title = optional($document->first('title'))->text();
        $description = optional($document->first('meta[name="description"]'))->getAttribute('content');

        return new UrlInfoResponse($h1, $title, $description, $response->status(), $urlId);
    }
}