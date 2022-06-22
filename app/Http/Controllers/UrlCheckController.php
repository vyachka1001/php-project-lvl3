<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UrlCheckRepository;
use App\Dto\Response\UrlInfoResponse;
use App\Services\Checkers\PageChecker;

class UrlCheckController extends Controller
{
    private UrlCheckRepository $urlCheckRepository;
    private PageChecker $pageChecker;

    public function __construct(UrlCheckRepository $urlCheckRepository, PageChecker $pageChecker)
    {
        $this->urlCheckRepository = $urlCheckRepository;
        $this->pageChecker = $pageChecker;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $urlId id of the url under checking
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, int $urlId): \Illuminate\Http\RedirectResponse
    {
        try {
            $urlInfo = $this->pageChecker->getUrlInfo($urlId);
            $this->urlCheckRepository->save($urlInfo);
            flash('Страница успешно проверена');
        } catch (\Exception $e) {
            flash($e->getMessage())->error();
        }

        return \redirect()->route('urls.show', ['id' => $urlId]);
    }
}
