<?php

namespace App\Http\Controllers\api\main;

use App\Http\Controllers\Controller;
use App\Models\JawabanDeteksiIbuMelahirkanStunting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiJawabanIbuMelahirkanStuntingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ibuMelahirkanStuntingId = $request->ibu_melahirkan_stunting_id;
        $jawabanDeteksiIbuMelahirkanStunting = new JawabanDeteksiIbuMelahirkanStunting();

        if ($ibuMelahirkanStuntingId) {
            return $jawabanDeteksiIbuMelahirkanStunting->where("deteksi_ibu_melahirkan_stunting_id", $ibuMelahirkanStuntingId)->orderBy('updated_at', 'desc')->get();
        }

        return $jawabanDeteksiIbuMelahirkanStunting->orderBy('updated_at', 'desc')->get();
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
            $request->validate([
                "*.deteksi_ibu_melahirkan_stunting_id" => 'required|exists:deteksi_ibu_melahirkan_stunting,id',
                "*.soal_id" => 'required|exists:soal_ibu_melahirkan_stunting,id',
                "*.jawaban" => 'required',
            ]);

            $field = [];

            foreach ($reqBody as $key => $value) {
                array_push($field, [
                    'id' => Str::uuid()->toString(),
                    'deteksi_ibu_melahirkan_stunting' => $value->deteksi_ibu_melahirkan_stunting_id,
                    'soal_id' => $value->soal_id,
                    'jawaban' => $value->jawaban,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            JawabanDeteksiIbuMelahirkanStunting::insert($field);
            return $field;
        } else {
            $request->validate([
                "deteksi_ibu_melahirkan_stunting_id" => 'required|exists:deteksi_ibu_melahirkan_stunting,id',
                "soal_id" => 'required|exists:soal_ibu_melahirkan_stunting,id',
                "jawaban" => 'required',
            ]);

            return JawabanDeteksiIbuMelahirkanStunting::create($request->all());
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
        return JawabanDeteksiIbuMelahirkanStunting::find($id);
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
            "deteksi_ibu_melahirkan_stunting_id" => 'required|exists:deteksi_ibu_melahirkan_stunting,id',
            "soal_id" => 'required|exists:soal_ibu_melahirkan_stunting,id',
            "jawaban" => 'required',
        ]);

        $jawabanDeteksiIbuMelahirkanStunting = JawabanDeteksiIbuMelahirkanStunting::find($id);

        if ($jawabanDeteksiIbuMelahirkanStunting) {
            $jawabanDeteksiIbuMelahirkanStunting->update($request->all());
            return $jawabanDeteksiIbuMelahirkanStunting;
        }

        return response([
            'message' => "Jawaban Deteksi Ibu Melahirkan Stunting with id $id doesn't exist"
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $deteksiIbuMelahirkanStuntingId = $request->deteksi_ibu_melahirkan_stunting_id;
        if ($id) {
            $jawabanDeteksiIbuMelahirkanStunting = JawabanDeteksiIbuMelahirkanStunting::find($id);

            if ($jawabanDeteksiIbuMelahirkanStunting) {
                return $jawabanDeteksiIbuMelahirkanStunting->delete();
            }
            return response([
                'message' => "Jawaban Deteksi Ibu Melahirkan Stunting with id $id doesn't exist"
            ], 400);
        }
        if ($deteksiIbuMelahirkanStuntingId) {
            $jawabanDeteksiIbuMelahirkanStunting = JawabanDeteksiIbuMelahirkanStunting::where('deteksi_ibu_melahirkan_stunting_id', $deteksiIbuMelahirkanStuntingId)->first();

            if ($jawabanDeteksiIbuMelahirkanStunting) {
                return JawabanDeteksiIbuMelahirkanStunting::where('deteksi_ibu_melahirkan_stunting_id', $deteksiIbuMelahirkanStuntingId)->delete();
            }
            return response([
                'message' => "Jawaban Deteksi Ibu Melahirkan Stunting with deteksi_ibu_melahirkan_stunting_id $deteksiIbuMelahirkanStuntingId doesn't exist"
            ], 400);
        }
    }
}
