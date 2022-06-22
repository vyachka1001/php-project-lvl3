<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UrlRepository
{
    public function findPaginatedUrls(int $urlPerPage)
    {
        return DB::table('urls')
            ->oldest()
            ->paginate($urlPerPage);
    }

    public function findIdByName(string $name)
    {
        $record = DB::table('urls')
            ->select('id')
            ->where('name', $name)
            ->get();

        return $record[0]->id;
    }

    public function save($name): bool
    {
        $record = DB::table('urls')
            ->select('id')
            ->where('name', $name)
            ->get();

        if (!empty($record[0])) {
            return false;
        }

        $dateTime = Carbon::now()->toDateTimeString();
        $id = DB::table('urls')->insertGetId(
            [
                'name' => $name,
                'created_at' => $dateTime
            ]
        );

        return true;
    }

    public function findById($id)
    {
        return DB::table('urls')->select('*')
            ->where('id', $id)
            ->get();
    }

    public function findNameById($id)
    {
        $url = DB::table('urls')
            ->select('name')
            ->where('id', $id)
            ->get();

        return $url[0]->name;
    }
}
