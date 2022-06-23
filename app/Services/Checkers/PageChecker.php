<?php

namespace App\Services\Checkers;

use App\Repositories\UrlRepository;
use App\Dto\Response\UrlInfoResponse;
use App\Repositories\UrlCheckRepository;
use Illuminate\Support\Facades\Http;
use DiDom\Document;

class PageChecker
{
    private UrlRepository $urlRepository;
    private UrlCheckRepository $urlCheckRepository;

    public function __construct(UrlRepository $urlRepository, UrlCheckRepository $urlCheckRepository)
    {
        $this->urlRepository = $urlRepository;
        $this->urlCheckRepository = $urlCheckRepository;
    }

     /**
     * Store new url check for corresponding url. Return bool, if check is stored, false otherwise.
     * @param int $urlId url's id
     *
     * @return bool
     */
    public function createCheck(int $urlId): bool
    {
        $urlInfo = $this->getUrlInfo($urlId);
        return $this->urlCheckRepository->save($urlInfo);
    }

    /**
     * Collect info about corresponding url.
     * @param int $urlId url's id
     *
     * @return UrlInfoResponse
     */
    public function getUrlInfo(int $urlId): UrlInfoResponse
    {
        $name = $this->urlRepository->findNameById($urlId);

        if (empty($name)) {
            throw new \Exception('Name with current id does not exist');
        }

        $response = Http::get($name);
        $document = new Document($response->body());

        $h1 = optional($document->first('h1'))->text();
        $title = optional($document->first('title'))->text();
        $description = optional($document->first('meta[name="description"]'))->getAttribute('content');

        return new UrlInfoResponse($h1, $title, $description, $response->status(), $urlId);
    }
}
