<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $urls = DB::table('urls')
            ->select('*')
            ->orderBy('id', 'asc')
            ->get();
        
        foreach ($urls as $url) {
            $url->lastCheck = DB::table('url_checks')
                ->where('url_id', $url->id)
                ->max('created_at');
        }
        
        return view('url.index', ['urls' => $urls]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('index');
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
        $validator = Validator::make($request->all(), 
            [
                'url.name' => 'required|max:255'
            ]
        );
        if ($validator->fails()) {
            flash('Input field is required')->error();
            return redirect()->back()->withInput();
        }

        $name = $request->input('url.name');
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
            flash('Url has been added')->success();
        } else {
            $id = $record[0]->id;
            flash('Url is already exists');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
