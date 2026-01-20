<?php

namespace App\Http\Controllers;

use App\ServiceAuth;
use App\Http\Requests\StoreServiceAuthRequest;
use App\Http\Requests\UpdateServiceAuthRequest;

class ServiceAuthController extends Controller
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
     * @param  \App\Http\Requests\StoreServiceAuthRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceAuthRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ServiceAuth  $serviceAuth
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceAuth $serviceAuth)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ServiceAuth  $serviceAuth
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceAuth $serviceAuth)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServiceAuthRequest  $request
     * @param  \App\ServiceAuth  $serviceAuth
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceAuthRequest $request, ServiceAuth $serviceAuth)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ServiceAuth  $serviceAuth
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceAuth $serviceAuth)
    {
        //
    }
}
