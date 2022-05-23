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

class KabupatenKotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('profil_ada');
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = KabupatenKota::where('provinsi_id', $request->provinsi)->orderBy('nama', 'asc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . url('masterData/kecamatan/' . $row->id) . '" class="btn btn-primary btn-sm me-1">Lihat</a><button id="btn-edit" class="btn btn-warning btn-sm me-1" value="' . $row->id . '" >Ubah</button><button id="btn-delete" class="btn btn-danger btn-sm me-1" value="' . $row->id . '" > Hapus</button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $provinsi = Provinsi::find($request->provinsi);
        return view('dashboard.pages.masterData.wilayah.kabupatenKota', compact('provinsi'));
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
                'nama' => ['required', Rule::unique('kabupaten_kota')->withoutTrashed()],
            ],
            [
                'nama.required' => 'Nama Kabupaten / Kota tidak boleh kosong',
                'nama.unique' => 'Nama Kabupaten / Kota sudah ada',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $kabupatenKota = new KabupatenKota();
        $kabupatenKota->nama = $request->nama;
        $kabupatenKota->provinsi_id = $request->provinsi;
        $kabupatenKota->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KabupatenKota  $kabupatenKota
     * @return \Illuminate\Http\Response
     */
    public function show(KabupatenKota $kabupatenKota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KabupatenKota  $kabupatenKota
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $kabupatenKota = KabupatenKota::find($request->kabupatenKota);
        return response()->json($kabupatenKota);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KabupatenKota  $kabupatenKota
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => ['required', Rule::unique('kabupaten_kota')->ignore($request->kabupatenKota)->withoutTrashed()],
            ],
            [
                'nama.required' => 'Nama Kabupaten / Kota tidak boleh kosong',
                'nama.unique' => 'Nama Kabupaten / Kota sudah ada',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $kabupatenKota = KabupatenKota::find($request->kabupatenKota);
        $kabupatenKota->nama = $request->nama;
        $kabupatenKota->provinsi_id = $request->provinsi;
        $kabupatenKota->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KabupatenKota  $kabupatenKota
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $kabupatenKota = KabupatenKota::find($request->kabupatenKota);
        $kabupatenKota->delete();

        $kecamatan = Kecamatan::where('kabupaten_kota_id', $request->kabupatenKota)->get();
        foreach ($kecamatan as $kec) {
            $kec->delete();
            $desa = DesaKelurahan::where('kecamatan_id', $kec->id)->get();
            foreach ($desa as $des) {
                $des->delete();
            }
        }

        return response()->json(['status' => 'success']);
    }
}
