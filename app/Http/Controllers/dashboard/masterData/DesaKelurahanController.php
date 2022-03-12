<?php

namespace App\Http\Controllers\dashboard\masterData;

use App\Http\Controllers\Controller;
use App\Models\Desa_Kelurahan;
use Illuminate\Http\Request;

class DesaKelurahanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.pages.utama.master.wilayah.desaKecamatan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.pages.utama.master.wilayah.desaKecamatan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Desa_Kelurahan  $desa_Kelurahan
     * @return \Illuminate\Http\Response
     */
    public function show(Desa_Kelurahan $desa_Kelurahan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Desa_Kelurahan  $desa_Kelurahan
     * @return \Illuminate\Http\Response
     */
    public function edit(Desa_Kelurahan $desa_Kelurahan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Desa_Kelurahan  $desa_Kelurahan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Desa_Kelurahan $desa_Kelurahan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Desa_Kelurahan  $desa_Kelurahan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Desa_Kelurahan $desa_Kelurahan)
    {
        //
    }
}
