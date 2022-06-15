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
            $urlInfo = self::getUrlInfo($response->body());
            DB::table('url_checks')->insert(
                [
                    'url_id' => $urlId,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'status_code' => $response->status(),
                    'h1' => $urlInfo->h1 ?? null,
                    'title' => $urlInfo->title ?? null,
                    'description' => $urlInfo->description ?? null
                ]
            );
            flash('Страница успешно проверена');
        } catch (\Exception $e) {
            flash($e->getMessage())->error();
        }

        return \redirect()->route('urls.show', ['id' => $urlId]);
    }

    /**
     * Collect info about corresponding url.
     *
     * @param  string  $body response body to research
     * 
     * @return \stdClass
     */
    private function getUrlInfo($body)
    {
        $info = new \stdClass();
        try {
            $document = new Document($body);
        } catch(\Exception $e) {
            return $info;
        }

        $info->h1 = optional($document->first('h1'))->text();
        $info->title = optional($document->first('title'))->text();
        $info->description = optional($document->first('meta[name="description"]'))->getAttribute('content');

        return $info;
    }
}
