<?php

namespace App\Http\Controllers\api\main;

use App\Http\Controllers\Controller;
use App\Models\Pemberitahuan;
use Illuminate\Http\Request;

class ApiPemberitahuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $relation = $request->relation;
        $pemberitahuan = new Pemberitahuan;

        if ($relation) {
            $pemberitahuan = Pemberitahuan::with('users', 'anggotaKeluarga');
        }

        return $pemberitahuan->get();
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
            'user_id' => 'required|exists:users,id',
            'fitur_id' => 'nullable',
            'anggota_keluarga_id' => 'required|exists:anggota_keluarga,id',
            'judul' => 'required',
            'isi' => 'required',
            'tentang' => 'required'
        ]);

        return Pemberitahuan::create($request->all());
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
            return Pemberitahuan::with('users', 'anggotaKeluarga')->where('id', $id)->first();
        }
        return Pemberitahuan::where('id', $id)->first();
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
            'user_id' => 'nullable|exists:users,id',
            'fitur_id' => 'nullable',
            'anggota_keluarga_id' => 'nullable|exists:anggota_keluarga,id',
            'judul' => 'nullable',
            'isi' => 'nullable',
            'tentang' => 'nullable'
        ]);

        $pemberitahuan = Pemberitahuan::find($id);

        if ($pemberitahuan) {
            $pemberitahuan->update($request->all());
            return $pemberitahuan;
        }

        return response([
            'message' => "Pemberitahuan with id $id doesn't exist"
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $id = $request->id;
        $userId = $request->user_id;
        if ($id) {
            $pemberitahuan = Pemberitahuan::find($id);

            if ($pemberitahuan) {
                return $pemberitahuan->delete();
            }
            return response([
                'message' => "Pemberitahuan with id $id doesn't exist"
            ], 400);
        }
        if ($userId) {
            $pemberitahuan = Pemberitahuan::where('user_id', $userId)->first();

            if ($pemberitahuan) {
                return Pemberitahuan::where('user_id', $userId)->delete();
            }
            return response([
                'message' => "Pemberitahuan with user_id $userId doesn't exist"
            ], 400);
        }
    }
}
