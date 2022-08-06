<?php

namespace App\Http\Controllers\api\main;

use App\Http\Controllers\Controller;
use App\Models\JawabanDeteksiDini;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiJawabanDeteksiDiniController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $deteksiDiniId = $request->deteksi_dini_id;
        $jawabanDeteksiDini = new JawabanDeteksiDini();

        if ($deteksiDiniId) {
            return $jawabanDeteksiDini->where("deteksi_dini_id", $deteksiDiniId)->orderBy('updated_at', 'desc')->get();
        }

        return $jawabanDeteksiDini->orderBy('updated_at', 'desc')->get();
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
                "*.deteksi_dini_id" => 'required|exists:deteksi_dini,id',
                "*.soal_id" => 'required|exists:soal_deteksi_dini,id',
                "*.jawaban" => 'required',
            ]);

            $field = [];

            foreach ($reqBody as $key => $value) {
                array_push($field, [
                    'id' => Str::uuid()->toString(),
                    'deteksi_dini_id' => $value->deteksi_dini_id,
                    'soal_id' => $value->soal_id,
                    'jawaban' => $value->jawaban,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            JawabanDeteksiDini::insert($field);
            return $field;
        } else {
            $request->validate([
                "deteksi_dini_id" => 'required|exists:deteksi_dini,id',
                "soal_id" => 'required|exists:soal_deteksi_dini,id',
                "jawaban" => 'required',
            ]);

            return JawabanDeteksiDini::create($request->all());
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
        return JawabanDeteksiDini::find($id);
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
            "deteksi_dini_id" => 'required|exists:deteksi_dini,id',
            "soal_id" => 'required|exists:soal_deteksi_dini,id',
            "jawaban" => 'required',
        ]);

        $jawabanDeteksiDini = JawabanDeteksiDini::find($id);

        if ($jawabanDeteksiDini) {
            $jawabanDeteksiDini->update($request->all());
            return $jawabanDeteksiDini;
        }

        return response([
            'message' => "Jawaban Deteksi Dini with id $id doesn't exist"
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
        $deteksiDiniId = $request->deteksi_dini_id;
        if ($id) {
            $jawabanDeteksiDini = JawabanDeteksiDini::find($id);

            if ($jawabanDeteksiDini) {
                return $jawabanDeteksiDini->delete();
            }
            return response([
                'message' => "Jawaban Deteksi Dini with id $id doesn't exist"
            ], 400);
        }
        if ($deteksiDiniId) {
            $jawabanDeteksiDini = JawabanDeteksiDini::where('deteksi_dini_id', $deteksiDiniId)->first();

            if ($jawabanDeteksiDini) {
                return JawabanDeteksiDini::where('deteksi_dini_id', $deteksiDiniId)->delete();
            }
            return response([
                'message' => "Jawaban Deteksi Dini with deteksi_dini_id $deteksiDiniId doesn't exist"
            ], 400);
        }
    }
}
