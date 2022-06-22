<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DiDom\Document;
use App\Repositories\UrlRepository;
use App\Repositories\UrlCheckRepository;
use App\Dto\Response\UrlInfoResponse;

class UrlCheckController extends Controller
{
    private $urlRepository;
    private $urlCheckRepository;

    public function __construct(UrlRepository $urlRepository, UrlCheckRepository $urlCheckRepository)
    {
        $this->urlRepository = $urlRepository;
        $this->urlCheckRepository = $urlCheckRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $urlId id of the url under checking
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $urlId)
    {
        $name = $this->urlRepository->findNameById($urlId);
        try {
            $urlInfo = $this->getUrlInfo($name, $urlId);
            $this->urlCheckRepository->save($urlInfo);
            flash('Страница успешно проверена');
        } catch (\Exception $e) {
            flash($e->getMessage())->error();
        }

        return \redirect()->route('urls.show', ['id' => $urlId]);
    }

    /**
     * Collect info about corresponding url.
     *
     * @param string $name url to research
     * @param string $urlId url's id 
     *
     * @return \UrlInfoResponse
     */
    private function getUrlInfo($name, $urlId)
    {
        $response = Http::get($name);
        $document = new Document($response->body());

        $h1 = optional($document->first('h1'))->text();
        $title = optional($document->first('title'))->text();
        $description = optional($document->first('meta[name="description"]'))->getAttribute('content');

        return new UrlInfoResponse($h1, $title, $description, $response->status(), $urlId);
    }
}
