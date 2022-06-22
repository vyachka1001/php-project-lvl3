<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\UrlRepository;
use App\Repositories\UrlCheckRepository;

class UrlController extends Controller
{
    private $urlRepository;
    private $urlCheckRepository;

    const URLS_PER_PAGE = 15;

    public function __construct(UrlRepository $urlRepository, UrlCheckRepository $urlCheckRepository)
    {
        $this->urlRepository = $urlRepository;
        $this->urlCheckRepository = $urlCheckRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $urls = $this->urlRepository->findPaginatedUrls(self::URLS_PER_PAGE);
        $lastChecks = $this->urlCheckRepository->findLastUrlChecks();

        return view('url.index', ['urls' => $urls, 'lastChecks' => $lastChecks]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request contains url info from form
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->input('url.name');
        $validator = Validator::make(
            $request->all(),
            [
                'url.name' => 'required|url|max:255'
            ]
        );
        if ($validator->fails() || empty(parse_url($name, PHP_URL_SCHEME))) {
            flash('Неккоректный URL')->error();
            return redirect()->route('welcome')
                ->withErrors($validator)
                ->withInput();
        }

        $isAdded = $this->urlRepository->save($name);
        if (!$isAdded) {
            flash('Страница уже существует');
        } else {
            flash('Страница успешно добавлена')->success();
        }

        $id = $this->urlRepository->findIdByName($name);

        return redirect()->route('urls.show', ['id' => $id]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id id of the showing url
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $url = $this->urlRepository->findById($id);
        $checks = $this->urlCheckRepository->findById($id);

        return view('url.show', ['url' => $url[0], 'checks' => $checks]);
    }
}
