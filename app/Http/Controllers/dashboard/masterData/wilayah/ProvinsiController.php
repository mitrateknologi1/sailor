<?php

namespace App\Http\Controllers\dashboard\masterData\wilayah;

use App\Http\Controllers\Controller;
use App\Models\DesaKelurahan;
use App\Models\KabupatenKota;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProvinsiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Provinsi::orderBy('nama', 'asc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . url('masterData/kabupatenKota/' . $row->id) . '" class="btn btn-primary btn-sm me-1">Lihat</a><button id="btn-edit" class="btn btn-warning btn-sm me-1" value="' . $row->id . '" >Ubah</button><button id="btn-delete" class="btn btn-danger btn-sm me-1" value="' . $row->id . '" > Hapus</button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('dashboard.pages.utama.masterData.wilayah.provinsi');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => ['required', Rule::unique('provinsi')->withoutTrashed()],
            ],
            [
                'nama.required' => 'Nama Provinsi tidak boleh kosong',
                'nama.unique' => 'Nama Provinsi sudah ada',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $provinsi = new Provinsi();
        $provinsi->nama = $request->nama;
        $provinsi->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Provinsi  $provinsi
     * @return \Illuminate\Http\Response
     */
    public function show(Provinsi $provinsi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Provinsi  $provinsi
     * @return \Illuminate\Http\Response
     */
    public function edit(Provinsi $provinsi)
    {
        return response()->json($provinsi);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Provinsi  $provinsi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Provinsi $provinsi)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => ['required', Rule::unique('provinsi')->ignore($provinsi->id)->withoutTrashed()],
            ],
            [
                'nama.required' => 'Nama Provinsi tidak boleh kosong',
                'nama.unique' => 'Nama Provinsi sudah ada',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $provinsi->nama = $request->nama;
        $provinsi->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Provinsi  $provinsi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Provinsi $provinsi)
    {
        $provinsi->delete();

        $kabupaten = KabupatenKota::where('provinsi_id', $provinsi->id)->get();
        foreach ($kabupaten as $kab) {
            $kab->delete();

            $kecamatan = Kecamatan::where('kabupaten_kota_id', $kab->id)->get();
            foreach ($kecamatan as $kec) {
                $kec->delete();

                $desaKelurahan = DesaKelurahan::where('kecamatan_id', $kec->id)->get();
                foreach ($desaKelurahan as $desa) {
                    $desa->delete();
                }
            }
        }

        return response()->json(['status' => 'success']);
    }
}
