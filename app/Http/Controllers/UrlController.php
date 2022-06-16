<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class UrlController extends Controller
{
    const URLS_PER_PAGE = 15;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $urls = DB::table('urls')
            ->oldest()
            ->paginate(self::URLS_PER_PAGE);

        $lastChecks = DB::table('url_checks')
            ->orderBy('url_id')
            ->latest()
            ->distinct('url_id')
            ->get()
            ->keyBy('url_id');

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

        $record = DB::table('urls')
            ->select('id')
            ->where('name', $name)
            ->get();

        if (empty($record[0])) {
            $dateTime = Carbon::now()->toDateTimeString();
            $id = DB::table('urls')->insertGetId(
                [
                    'name' => $name,
                    'created_at' => $dateTime
                ]
            );
            flash('Страница успешно добавлена')->success();
        } else {
            $id = $record[0]->id;
            flash('Страница уже существует');
        }

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
        $url = DB::table('urls')->select('*')
            ->where('id', $id)
            ->get();

        $checks = DB::table('url_checks')->select('*')
            ->where('url_id', $id)
            ->orderBy('id', 'desc')
            ->get();

        return view('url.show', ['url' => $url[0], 'checks' => $checks]);
    }
}
