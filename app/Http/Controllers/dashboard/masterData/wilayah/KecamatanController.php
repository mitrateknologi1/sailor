<?php

namespace App\Http\Controllers\dashboard\masterData\wilayah;

use App\Http\Controllers\Controller;
use App\Models\KabupatenKota;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class KecamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Kecamatan::where('kabupaten_kota_id', $request->kabupatenKota)->orderBy('nama', 'asc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($request) {
                    $actionBtn = '<a href="' . url('desaKelurahan/' . $row->id) . '" class="btn btn-primary btn-sm me-1">Lihat</a><a href="' . url('kecamatan/' . $request->kabupatenKota . '/' . $row->id . '/edit') . '" class="btn btn-warning btn-sm me-1" value="' . $row->id . '" >Ubah</a><button id="btn-delete" class="btn btn-danger btn-sm me-1" value="' . $row->id . '" > Hapus</button>';
                    return $actionBtn;
                })
                ->addColumn('statusPolygon', function ($row) {
                    if ($row->polygon) {
                        return '<span class="badge bg-success">Ada</span>';
                    } else {
                        return '<span class="badge bg-danger">Tidak Ada</span>';
                    }
                })
                ->addColumn('warnaPolygon', function ($row) {
                    if ($row->warna_polygon) {
                        return '<input type="color" id="favcolor" name="favcolor" value="' . $row->warna_polygon . '" disabled>';
                    } else {
                        return '<span class="badge bg-danger">Tidak Ada</span>';
                    }
                })
                ->rawColumns(['action', 'statusPolygon', 'warnaPolygon'])
                ->make(true);
        }

        $kabupatenKota = KabupatenKota::find($request->kabupatenKota);
        return view('dashboard.pages.masterData.wilayah.kecamatan.index', compact('kabupatenKota'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $kabupatenKota = KabupatenKota::find($request->kabupatenKota);
        return view('dashboard.pages.masterData.wilayah.kecamatan.create', compact('kabupatenKota'));
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
                'nama' => ['required', Rule::unique('kecamatan')->withoutTrashed()],
                'polygon' => 'required',
                'warna_polygon' => ['required', Rule::unique('kecamatan')->withoutTrashed()],
            ],
            [
                'nama.required' => 'Nama Kecamatan tidak boleh kosong',
                'nama.unique' => 'Nama Kecamatan sudah ada',
                'polygon.required' => 'Polygon tidak boleh kosong',
                'warna_polygon.required' => 'Warna tidak boleh kosong',
                'warna_polygon.unique' => 'Warna sudah ada',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $kecamatan = new Kecamatan();
        $kecamatan->nama = $request->nama;
        $kecamatan->kabupaten_kota_id = $request->kabupatenKota;
        $kecamatan->polygon = $request->polygon;
        $kecamatan->warna_polygon = $request->warna_polygon;
        $kecamatan->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kecamatan  $kecamatan
     * @return \Illuminate\Http\Response
     */
    public function show(Kecamatan $kecamatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kecamatan  $kecamatan
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $kecamatan = Kecamatan::find($request->kecamatan);
        $kabupatenKota = KabupatenKota::find($request->kabupatenKota);
        return view('dashboard.pages.utama.masterData.wilayah.kecamatan.edit', compact('kecamatan', 'kabupatenKota'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kecamatan  $kecamatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => ['required', Rule::unique('kecamatan')->ignore($request->kecamatan)->withoutTrashed()],
                'polygon' => 'required',
                'warna_polygon' => ['required', Rule::unique('kecamatan')->ignore($request->kecamatan)->withoutTrashed()],
            ],
            [
                'nama.required' => 'Nama Kecamatan tidak boleh kosong',
                'nama.unique' => 'Nama Kecamatan sudah ada',
                'polygon.required' => 'Polygon tidak boleh kosong',
                'warna_polygon.required' => 'Warna tidak boleh kosong',
                'warna_polygon.unique' => 'Warna sudah ada',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $kecamatan = Kecamatan::find($request->kecamatan);
        $kecamatan->nama = $request->nama;
        $kecamatan->polygon = $request->polygon;
        $kecamatan->warna_polygon = $request->warna_polygon;
        $kecamatan->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kecamatan  $kecamatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $kecamatan = Kecamatan::find($request->kecamatan);
        $kecamatan->delete();

        $kecamatan->desaKelurahan()->delete();

        return response()->json(['status' => 'success']);
    }

    public function getMapData(Request $request)
    {
        if ($request->id) {
            $kecamatan = Kecamatan::find($request->id);
        } else {
            $kecamatan = Kecamatan::whereNotNull('polygon')->where('kabupaten_kota_id', $request->kabupatenKota)->where(function ($query) use ($request) {
                if ($request->kecamatanId) {
                    $query->where('id', '!=', $request->kecamatanId);
                }
            })->orderBy('id', 'desc')->get();
        }

        if ($kecamatan) {
            return response()->json(['status' => 'success', 'data' => $kecamatan]);
        } else {
            return response()->json(['status' => 'error']);
        }
    }
}
