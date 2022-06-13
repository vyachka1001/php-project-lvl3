<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use DiDom\Document;

class UrlCheckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $url = DB::table('urls')
        ->select('name')
        ->where('id', $urlId)
        ->get();

        $name = $url[0]->name;
        
        try {
            $response = Http::get($name);
            flash('Страница успешно проверена');
            $urlInfo = self::getUrlInfo($name);
            dump($urlInfo);
            DB::table('url_checks')->insert(
                [
                    'url_id' => $urlId,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'status_code' => $response->status(),
                    'h1' => $urlInfo->h1,
                    'title' => $urlInfo->title,
                    'description' => $urlInfo->description
                ]
            );
        } catch (\Exception $e) {
            flash($e->getMessage())->error();
        }

        return \redirect()->route('urls.show', ['id' => $urlId]);
    }

    /**
     * Collect info about corresponding url.
     *
     * @param  string  $url url to research
     * 
     * @return \stdClass
     */
    private function getUrlInfo($url)
    {
        $document = new Document($url, true);
        $info = new \stdClass();

        $info->h1 = $document->find('h1')[0]->text();
        $info->title = $document->find('title')[0]->text();
        $info->description = $document->find('meta[name="description"]')[0]->getAttribute('content');

        return $info;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
