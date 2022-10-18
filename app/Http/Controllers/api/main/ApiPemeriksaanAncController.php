<?php

namespace App\Http\Controllers\api\main;

use App\Http\Controllers\Controller;
use App\Models\PemeriksaanAnc;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ApiPemeriksaanAncController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "anc_id"=> 'required|exists:anc,id',
            "kehamilan_ke"=> 'required|numeric',
            "tanggal_haid_terakhir"=> 'required',
            "tinggi_badan"=> 'required|numeric',
            "berat_badan"=>'required|numeric',
            "tekanan_darah_sistolik"=> 'required|numeric',
            "tekanan_darah_diastolik"=>'required|numeric',
            "lengan_atas"=> 'required|numeric',
            "tinggi_fundus"=>'required|numeric',
            "denyut_jantung_janin"=> 'required|numeric',
            "hemoglobin_darah"=> 'required|numeric',
            "tanggal_perkiraan_lahir"=> 'required',
            "usia_kehamilan"=> 'required|numeric'
        ]);

        $data = [
            "anc_id" => $request->anc_id,
            "kehamilan_ke" => $request->kehamilan_ke,
            "tanggal_haid_terakhir" => $request->tanggal_haid_terakhir,
            "tinggi_badan" => $request->tinggi_badan,
            "berat_badan" => $request->berat_badan,
            "tekanan_darah_sistolik" => $request->tekanan_darah_sistolik,
            "tekanan_darah_diastolik" => $request->tekanan_darah_diastolik,
            "lengan_atas" => $request->lengan_atas,
            "tinggi_fundus" => $request->tinggi_fundus,
            "denyut_jantung_janin" => $request->denyut_jantung_janin,
            "hemoglobin_darah" => $request->hemoglobin_darah,
            "tanggal_perkiraan_lahir" => $request->tanggal_perkiraan_lahir,
            "usia_kehamilan" => $request->usia_kehamilan,
        ];
        
        return PemeriksaanAnc::create($data);
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
        $request->validate([
            "anc_id" => "required|exists:anc,id",
            "kehamilan_ke" => "required|numeric",
            "tanggal_haid_terakhir" => "required",
            "tinggi_badan" => "required|numeric",
            "berat_badan" => "required|numeric",
            "tekanan_darah_sistolik" => "required|numeric",
            "tekanan_darah_diastolik" => "required|numeric",
            "lengan_atas" => "required|numeric",
            "tinggi_fundus" => "required|numeric",
            "denyut_jantung_janin" => "required|numeric",
            "hemoglobin_darah" => "required|numeric",
            "tanggal_perkiraan_lahir" => "required",
            "usia_kehamilan" => "required|numeric",
        ]);

        $data = [
            "anc_id" => $request->anc_id,
            "kehamilan_ke" => $request->kehamilan_ke,
            "tanggal_haid_terakhir" => $request->tanggal_haid_terakhir,
            "tinggi_badan" => $request->tinggi_badan,
            "berat_badan" => $request->berat_badan,
            "tekanan_darah_sistolik" => $request->tekanan_darah_sistolik,
            "tekanan_darah_diastolik" => $request->tekanan_darah_diastolik,
            "lengan_atas" => $request->lengan_atas,
            "tinggi_fundus" => $request->tinggi_fundus,
            "denyut_jantung_janin" => $request->denyut_jantung_janin,
            "hemoglobin_darah" => $request->hemoglobin_darah,
            "tanggal_perkiraan_lahir" => $request->tanggal_perkiraan_lahir,
            "usia_kehamilan" => $request->usia_kehamilan,
        ];

        $anc = PemeriksaanAnc::find($id);

        if ($anc) {
            $anc->update($data);
            return $anc;
        }

        return response([
            'message' => "Pemeriksaan ANC with id $id doesn't exist"
        ], 404);
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
