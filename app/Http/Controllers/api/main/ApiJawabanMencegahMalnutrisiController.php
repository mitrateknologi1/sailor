<?php

namespace App\Http\Controllers\api\main;

use App\Http\Controllers\Controller;
use App\Models\JawabanMencegahMalnutrisi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiJawabanMencegahMalnutrisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $mencegahMalnutrisiId = $request->mencegah_malnutrisi_id;
        $jawabanMencegahMalnutrisi = new JawabanMencegahMalnutrisi;

        if ($mencegahMalnutrisiId) {
            $data = $jawabanMencegahMalnutrisi->where("mencegah_malnutrisi_id", $mencegahMalnutrisiId)->orderBy('updated_at', 'desc')->get();
            if(count($data) < 1 ){
                return response([
                    'message' => "Jawaban Mencegah Malnutrisi with malnutrisi id $mencegahMalnutrisiId doesn't exist"
                ], 404);
            }
            return $data;
        }

        return $jawabanMencegahMalnutrisi->orderBy('updated_at', 'desc')->get();
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
                "*.mencegah_malnutrisi_id" => 'required|exists:mencegah_malnutrisi,id',
                "*.soal_id" => 'required|exists:soal_mencegah_malnutrisi,id',
                "*.jawaban" => 'required',
            ]);

            $field = [];

            foreach ($reqBody as $key => $value) {
                array_push($field, [
                    'id' => Str::uuid()->toString(),
                    'mencegah_malnutrisi_id' => $value->mencegah_malnutrisi_id,
                    'soal_id' => $value->soal_id,
                    'jawaban' => $value->jawaban,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            JawabanMencegahMalnutrisi::insert($field);
            return $field;
        } else {
            $request->validate([
                "mencegah_malnutrisi_id" => 'required|exists:mencegah_malnutrisi,id',
                "soal_id" => 'required|exists:soal_mencegah_malnutrisi,id',
                "jawaban" => 'required',
            ]);

            return JawabanMencegahMalnutrisi::create($request->all());
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
        return JawabanMencegahMalnutrisi::find($id);
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
            "mencegah_malnutrisi_id" => 'required|exists:mencegah_malnutrisi,id',
            "soal_id" => 'required|exists:soal_mencegah_malnutrisi,id',
            "jawaban" => 'required',
        ]);

        $jawabanMencegahMalnutrisi = JawabanMencegahMalnutrisi::find($id);

        if ($jawabanMencegahMalnutrisi) {
            $jawabanMencegahMalnutrisi->update($request->all());
            return $jawabanMencegahMalnutrisi;
        }

        return response([
            'message' => "Jawaban Mencegah Malnutrisi with id $id doesn't exist"
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
        $mencegahMalnutrisiId = $request->mencegah_malnutrisi_id;
        if ($id) {
            $jawabanMencegahMalnutrisi = JawabanMencegahMalnutrisi::find($id);

            if ($jawabanMencegahMalnutrisi) {
                return $jawabanMencegahMalnutrisi->delete();
            }
            return response([
                'message' => "Jawaban Mencegah Malnutrisi with id $id doesn't exist"
            ], 404);
        }
        if ($mencegahMalnutrisiId) {
            $jawabanMencegahMalnutrisi = JawabanMencegahMalnutrisi::where('mencegah_malnutrisi_id', $mencegahMalnutrisiId)->first();

            if (!$jawabanMencegahMalnutrisi) {
                return response([
                    'message' => "Jawaban Mencegah Malnutrisi with mencegah_malnutrisi_id $mencegahMalnutrisiId doesn't exist"
                ], 404);
            }
            JawabanMencegahMalnutrisi::where('mencegah_malnutrisi_id', $mencegahMalnutrisiId)->delete();
            return response([
                'message' => "Jawaban Mencegah Malnutrisi deleted"
            ], 200); 
        }
    }
}
