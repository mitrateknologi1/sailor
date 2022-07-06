<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKeluarga;
use Illuminate\Http\Request;

class ApiAnggotaKeluargaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageSize = $request->page_size ?? 20;
        $relation = $request->relation;
        $anggotaKeluarga = null;

        if ($relation) {
            $anggotaKeluarga = AnggotaKeluarga::with('kartuKeluarga', 'user', 'statusHubunganDalamKeluarga', 'bidan', 'wilayahDomisili', 'agama', 'pendidikan', 'pekerjaan', 'golonganDarah', 'statusPerkawinan');
        } else {
            $anggotaKeluarga = new AnggotaKeluarga;
        }

        return $anggotaKeluarga->paginate($pageSize);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reqBody = json_decode($request->getContent());
        if (is_array($reqBody) && sizeof($reqBody) > 0) {
        } else {
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
