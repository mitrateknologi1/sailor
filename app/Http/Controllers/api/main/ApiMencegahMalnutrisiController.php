<?php

namespace App\Http\Controllers\api\main;

use App\Http\Controllers\Controller;
use App\Models\MencegahMalnutrisi;
use Illuminate\Http\Request;

class ApiMencegahMalnutrisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $relation = $request->relation;
        $randaKabilasaId = $request->randa_kabilas_id;
        $mencegahMalnutrisi = new MencegahMalnutrisi;

        if ($relation) {
            $mencegahMalnutrisi = MencegahMalnutrisi::with('randaKabilasa');
        }
        if ($randaKabilasaId) {
            $mencegahMalnutrisi =  MencegahMalnutrisi::where('randa_kabilasa_id', $randaKabilasaId);
        }

        return $mencegahMalnutrisi->get();
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
            "randa_kabilasa_id" => "required|exists:randa_kabilasa,id",
            "lingkar_lengan_atas" => "required",
            "tinggi_badan" => "required",
            "berat_badan" => "required",
        ]);

        return MencegahMalnutrisi::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $relation = $request->relation;

        if ($relation) {
            return MencegahMalnutrisi::with('randaKabilasa')->where('id', $id)->first();
        }
        return MencegahMalnutrisi::where('id', $id)->first();
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
            "randa_kabilasa_id" => "nullable|exists:randa_kabilasa,id",
            "lingkar_lengan_atas" => "nullable",
            "tinggi_badan" => "nullable",
            "berat_badan" => "nullable",
        ]);

        $mencegahMalnutrisi = MencegahMalnutrisi::find($id);

        if ($mencegahMalnutrisi) {
            $mencegahMalnutrisi->update($request->all());
            return $mencegahMalnutrisi;
        }

        return response([
            'message' => "Mencegah Malnutrisi with id $id doesn't exist"
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mencegahMalnutrisi = MencegahMalnutrisi::find($id);

        if (!$mencegahMalnutrisi) {
            return response([
                'message' => "Mencegah Malnutrisi with id $id doesn't exist"
            ], 400);
        }

        return $mencegahMalnutrisi->delete();
    }
}
