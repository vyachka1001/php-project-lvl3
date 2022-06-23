<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UrlRepository
{
    /**
     * Returns oldest urls.
     * If count is more than records, returns all records. If there are no records, returns empty collection.
     * @param int $urlPerPage Count of returning urls. 
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
     * Returns null, if there is no such id.
     *
     * @param int $id Corresponding id.
     *
     * @return \stdClass|null
     */
    public function findById(int $id): ?\stdClass
    {
        $record = DB::table('urls')->select('*')
            ->where('id', $id)
            ->get();

        return $record[0] ?? null;
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
