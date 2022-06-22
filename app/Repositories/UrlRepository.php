<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UrlRepository
{
    /**
     * Returns oldest urls.
     * @param int $urlPerPage Count of returning urls. If count is more than records, returns all records.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function findPaginatedUrls(int $urlPerPage): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return DB::table('urls')
            ->oldest()
            ->paginate($urlPerPage);
    }

    /**
     * Returns id by corresponding name.
     * If there is no such name in db, returns null.
     *
     * @param string $name corresponding url's name.
     *
     * @return int|null
     */
    public function findIdByName(string $name): ?int
    {
        $record = DB::table('urls')
            ->select('id')
            ->where('name', $name)
            ->get();

        return $record[0]->id ?? null;
    }

    /**
     * Inserts url into db.
     * Returns true, if data insertion is completed.
     *
     * @param string $name Corresponding url.
     *
     * @return bool
     */
    public function save(string $name): bool
    {
        $id = $this->findIdByName($name);

        if (!empty($id)) {
            return false;
        }

        $dateTime = Carbon::now()->toDateTimeString();
        $result = DB::table('urls')->insert(
            [
                'name' => $name,
                'created_at' => $dateTime
            ]
        );

        return $result;
    }

     /**
     * Returns record by corresponding id
     * Returns empty collection, if there is no such id.
     *
     * @param int $id Corresponding id.
     *
     * @return \Illuminate\Support\Collection
     */
    public function findById(int $id): \Illuminate\Support\Collection
    {
        return DB::table('urls')->select('*')
            ->where('id', $id)
            ->get();
    }

    /**
     * Returns name by corresponding id.
     * If there is no such id in db, returns null.
     *
     * @param int $id corresponding url's id.
     *
     * @return string|null
     */
    public function findNameById(int $id): ?string
    {
        $url = DB::table('urls')
            ->select('name')
            ->where('id', $id)
            ->get();

        return $url[0]->name ?? null;
    }
}
