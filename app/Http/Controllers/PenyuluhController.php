<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePenyuluhRequest;
use App\Http\Requests\UpdatePenyuluhRequest;
use App\Models\Penyuluh;

class PenyuluhController extends Controller
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
     * @param  \App\Http\Requests\StorePenyuluhRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePenyuluhRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penyuluh  $penyuluh
     * @return \Illuminate\Http\Response
     */
    public function show(Penyuluh $penyuluh)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penyuluh  $penyuluh
     * @return \Illuminate\Http\Response
     */
    public function edit(Penyuluh $penyuluh)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePenyuluhRequest  $request
     * @param  \App\Models\Penyuluh  $penyuluh
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePenyuluhRequest $request, Penyuluh $penyuluh)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penyuluh  $penyuluh
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penyuluh $penyuluh)
    {
        //
    }
}
