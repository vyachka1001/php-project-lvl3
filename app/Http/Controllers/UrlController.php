<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Either add new url to database and redirect to it's page or show existing url page .
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $data = $request->input('url');
        $name = $data['name'];

        $record = DB::table('urls')
            ->select('id')
            ->where('name', $name)
            ->get();
        $id = $record[0]->id;

        if (empty($id)) {
            $dateTime = Carbon::now()->toDateTimeString();
            $id = DB::table('urls')->insertGetId([
                'name' => $name,
                'created_at' => $dateTime
            ]);
        }

        return redirect()->route('showUrl', ['id' => $id]);
    }

    public function show($id)
    {

        return view('show', ['id' => $id]);
    }
}
