<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Managekey;
use Illuminate\Support\Str;
use mysql_xdevapi\Exception;

class ManageKeysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\request()->list) {
            $keys = Managekey::where('name', '=', \request()->list)->where('usedby', '=', NULL)->get();
        } else {
            $keys = Managekey::where('usedby', '=', NULL)->groupBy('name')->get();
        }
        return view('managekeys', ['keys' => $keys]);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        for ($x = 1; $x <= $request->piece; $x++) {
            $code = sprintf('%s-%s-%s-%s-%s', str::random(4), str::random(4), str::random(4), str::random(4), str::random(4));
            if (Managekey::where('key', '=', $code)->first()) {
                $code = sprintf('%s-%s-%s-%s-%s', str::random(4), str::random(4), str::random(4), str::random(4), str::random(4));
                if (Managekey::where('key', '=', $code)->first()) {
                    $code = sprintf('%s-%s-%s-%s-%s', str::random(4), str::random(4), str::random(4), str::random(4), str::random(4));
                    if (Managekey::where('key', '=', $code)->first()) {
                        $code = sprintf('%s-%s-%s-%s-%s', str::random(4), str::random(4), str::random(4), str::random(4), str::random(4));
                    }
                }
            }
            $Managekey = Managekey::create([
                'key' => mb_strtoupper($code),
                'owner'=>$request->owner?:'',
                'name' => $request->name,
                'services' => array_keys($request->services),
                'downs' => $request->downs,
                'max' => $request->max,
                'days' => $request->days,
            ])->id;
        }
        return redirect()->route('panel.managekeys.index', ['list' => $request->name])->with('result_post', json_encode([
            'status' => 'success',
            'message' => __("Transaction Successful!")
        ]));

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Managekey $Managekey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Managekey $Managekey)
    {
        try {
            $Managekey->deleteOrFail();
            return redirect()->back()->with('result_post', json_encode([
                'status' => 'success',
                'message' => __("Transaction Successful!")
            ]));
        } catch (\Throwable $e) {
            return redirect()->back()->with('result_post', json_encode([
                'status' => 'danger',
                'message' => __("Transaction Failed!")
            ]));
        }
    }
}
