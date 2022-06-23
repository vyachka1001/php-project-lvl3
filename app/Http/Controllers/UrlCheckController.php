<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Checkers\PageChecker;

class UrlCheckController extends Controller
{
    private PageChecker $pageChecker;

    public function __construct(PageChecker $pageChecker)
    {
        $this->pageChecker = $pageChecker;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param int $urlId id of the url under checking
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(int $urlId): \Illuminate\Http\RedirectResponse
    {
        try {
            $this->pageChecker->createCheck($urlId);    
            flash('Страница успешно проверена');
        } catch (\Exception $e) {
            flash($e->getMessage())->error();
        }

        return \redirect()->route('urls.show', ['id' => $urlId]);
    }
}
