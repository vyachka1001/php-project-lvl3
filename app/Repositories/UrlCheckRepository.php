<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Dto\Response\UrlInfoResponse;

class UrlCheckRepository
{
    /**
     * Returns latests url checks.
     * Returns empty collection if there are no checks.
     *
     * @return \Illuminate\Support\Collection
     */
    public function findLastUrlChecks(): \Illuminate\Support\Collection
    {
        return DB::table('url_checks')
            ->orderBy('url_id')
            ->latest()
            ->distinct('url_id')
            ->get()
            ->keyBy('url_id');
    }

    /**
     * Returns checks for current url_id.
     * Returns empty collection if there are no checks.
     *
     * @param int $id id of the url under checking
     *
     * @return \Illuminate\Support\Collection
     */
    public function findById(int $id): \Illuminate\Support\Collection
    {
        return DB::table('url_checks')->select('*')
            ->where('url_id', $id)
            ->orderBy('id', 'desc')
            ->get();
    }

    /**
     * Inserts corresponding info into db.
     * Returns true, if data insertion is completed.
     *
     * @param UrlInfoResponse $urlInfo corresponding url info
     *
     * @return bool
     */
    public function save(UrlInfoResponse $urlInfo): bool
    {
        $result =  DB::table('url_checks')->insert(
            [
                'url_id' => $urlInfo->getUrlId(),
                'created_at' => Carbon::now()->toDateTimeString(),
                'status_code' => $urlInfo->getStatus(),
                'h1' => $urlInfo->getH1(),
                'title' => $urlInfo->getTitle(),
                'description' => $urlInfo->getDescription()
            ]
        );

        return $result;
    }
}
