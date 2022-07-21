<?php

namespace App\Http\Controllers\api\main;

use App\Http\Controllers\Controller;
use App\Models\MencegahPernikahanDini;
use Illuminate\Http\Request;

class ApiMencegahPernikahanDiniController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $relation = $request->relation;
        $randaKabilasaId = $request->randa_kabilasa_id;
        $mencegahPernikahanDini = new MencegahPernikahanDini;

        if ($relation) {
            $mencegahPernikahanDini = MencegahPernikahanDini::with('randaKabilasa');
        }
        if ($randaKabilasaId) {
            error_log($randaKabilasaId);
            return $mencegahPernikahanDini->where('randa_kabilasa_id', $randaKabilasaId)->orderBy('updated_at', 'desc')->get();
        }

        return $mencegahPernikahanDini->orderBy('updated_at', 'desc')->get();
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
            "jawaban_1" => "required",
            "jawaban_2" => "required",
            "jawaban_3" => "required",
        ]);

        return MencegahPernikahanDini::create($request->all());
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
            return MencegahPernikahanDini::with('randaKabilasa')->where('id', $id)->first();
        }
        return MencegahPernikahanDini::where('id', $id)->first();
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
            "jawaban_1" => "nullable",
            "jawaban_2" => "nullable",
            "jawaban_3" => "nullable",
        ]);

        $mencegahPernikahanDini = MencegahPernikahanDini::find($id);

        if ($mencegahPernikahanDini) {
            $mencegahPernikahanDini->update($request->all());
            return $mencegahPernikahanDini;
        }

        return response([
            'message' => "Mencegah Pernikahan Dini with id $id doesn't exist"
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
        $mencegahPernikahanDini = MencegahPernikahanDini::find($id);

        if (!$mencegahPernikahanDini) {
            return response([
                'message' => "Mencegah Pernikahan Dini with id $id doesn't exist"
            ], 400);
        }

        return $mencegahPernikahanDini->delete();
    }
}
