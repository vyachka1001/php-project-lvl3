<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Dto\Response\UrlInfoResponse;

class UrlCheckRepository
{
    public function findLastUrlChecks()
    {
        return DB::table('url_checks')
            ->orderBy('url_id')
            ->latest()
            ->distinct('url_id')
            ->get()
            ->keyBy('url_id');
    }

    public function findById($id)
    {
        return DB::table('url_checks')->select('*')
            ->where('url_id', $id)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function save(UrlInfoResponse $urlInfo)
    {
        DB::table('url_checks')->insert(
            [
                'url_id' => $urlInfo->getUrlId(),
                'created_at' => Carbon::now()->toDateTimeString(),
                'status_code' => $urlInfo->getStatus(),
                'h1' => $urlInfo->getH1(),
                'title' => $urlInfo->getTitle(),
                'description' => $urlInfo->getDescription()
            ]
        );
    }
}