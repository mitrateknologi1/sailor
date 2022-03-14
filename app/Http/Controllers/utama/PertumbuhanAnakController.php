<?php

namespace App\Http\Controllers\utama;

use GuzzleHttp\Psr7\Request;
use App\Models\KartuKeluarga;
use App\Models\PertumbuhanAnak;
use App\Http\Controllers\Controller;

class PertumbuhanAnakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.pages.utama.tumbuhKembang.pertumbuhanAnak.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'kartuKeluarga' => KartuKeluarga::latest()->get(),
        ];
        return view('dashboard.pages.utama.tumbuhKembang.pertumbuhanAnak.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePertumbuhanAnakRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PertumbuhanAnak  $pertumbuhanAnak
     * @return \Illuminate\Http\Response
     */
    public function show(PertumbuhanAnak $pertumbuhanAnak)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PertumbuhanAnak  $pertumbuhanAnak
     * @return \Illuminate\Http\Response
     */
    public function edit(PertumbuhanAnak $pertumbuhanAnak)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePertumbuhanAnakRequest  $request
     * @param  \App\Models\PertumbuhanAnak  $pertumbuhanAnak
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PertumbuhanAnak $pertumbuhanAnak)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PertumbuhanAnak  $pertumbuhanAnak
     * @return \Illuminate\Http\Response
     */
    public function destroy(PertumbuhanAnak $pertumbuhanAnak)
    {
        //
    }
}
