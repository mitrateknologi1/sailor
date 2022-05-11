<?php

namespace App\Http\Controllers\dashboard\masterData\wilayah;

use App\Http\Controllers\Controller;
use App\Models\DesaKelurahan;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DesaKelurahanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DesaKelurahan::where('kecamatan_id', $request->kecamatan)->orderBy('nama', 'asc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($request) {
                    $actionBtn = '<a href="' . url('masterData/desaKelurahan/' . $request->kecamatan . '/' . $row->id . '/edit') . '" class="btn btn-warning btn-sm me-1" value="' . $row->id . '" >Ubah</a><button id="btn-delete" class="btn btn-danger btn-sm me-1" value="' . $row->id . '" > Hapus</button>';
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

        $kecamatan = Kecamatan::find($request->kecamatan);
        return view('dashboard.pages.masterData.wilayah.desaKelurahan.index', compact('kecamatan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $kecamatan = Kecamatan::find($request->kecamatan);
        return view('dashboard.pages.masterData.wilayah.desaKelurahan.create', compact('kecamatan'));
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
                'nama' => ['required', Rule::unique('desa_kelurahan')->withoutTrashed()],
                'polygon' => 'required',
                'warna_polygon' => ['required', Rule::unique('desa_kelurahan')->withoutTrashed()],
            ],
            [
                'nama.required' => 'Nama Desa/Kelurahan tidak boleh kosong',
                'nama.unique' => 'Nama Desa/Kelurahan sudah ada',
                'polygon.required' => 'Polygon tidak boleh kosong',
                'warna_polygon.required' => 'Warna tidak boleh kosong',
                'warna_polygon.unique' => 'Warna sudah ada',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $desaKelurahan = new DesaKelurahan();
        $desaKelurahan->nama = $request->nama;
        $desaKelurahan->kecamatan_id = $request->kecamatan;
        $desaKelurahan->polygon = $request->polygon;
        $desaKelurahan->warna_polygon = $request->warna_polygon;
        $desaKelurahan->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DesaKelurahan  $desaKelurahan
     * @return \Illuminate\Http\Response
     */
    public function show(DesaKelurahan $desaKelurahan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DesaKelurahan  $desaKelurahan
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $desaKelurahan = DesaKelurahan::find($request->desaKelurahan);
        $kecamatan = Kecamatan::find($desaKelurahan->kecamatan_id);
        return view('dashboard.pages.masterData.wilayah.desaKelurahan.edit', compact('desaKelurahan', 'kecamatan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DesaKelurahan  $desaKelurahan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => ['required', Rule::unique('desa_kelurahan')->where('kecamatan_id', $request->kecamatan)->ignore($request->desaKelurahan)->withoutTrashed()],
                'polygon' => 'required',
                'warna_polygon' => ['required', Rule::unique('desa_kelurahan')->ignore($request->desaKelurahan)->withoutTrashed()],
            ],
            [
                'nama.required' => 'Nama Desa/Kelurahan tidak boleh kosong',
                'nama.unique' => 'Nama Desa/Kelurahan sudah ada',
                'polygon.required' => 'Polygon tidak boleh kosong',
                'warna_polygon.required' => 'Warna tidak boleh kosong',
                'warna_polygon.unique' => 'Warna sudah ada',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $desaKelurahan = DesaKelurahan::find($request->desaKelurahan);
        $desaKelurahan->nama = $request->nama;
        $desaKelurahan->polygon = $request->polygon;
        $desaKelurahan->warna_polygon = $request->warna_polygon;
        $desaKelurahan->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DesaKelurahan  $desaKelurahan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $desaKelurahan = DesaKelurahan::find($request->desaKelurahan);
        $desaKelurahan->delete();

        return response()->json(['status' => 'success']);
    }

    public function getMapData(Request $request)
    {
        if ($request->id) {
            $desaKelurahan = DesaKelurahan::find($request->id);
        } else {
            $desaKelurahan = DesaKelurahan::whereNotNull('polygon')->where('kecamatan_id', $request->kecamatan)->where(function ($query) use ($request) {
                if ($request->desaKelurahanId) {
                    $query->where('id', '==', $request->desaKelurahanId);
                }
            })->orderBy('id', 'desc')->get();
        }

        if ($desaKelurahan) {
            return response()->json(['status' => 'success', 'data' => $desaKelurahan]);
        } else {
            return response()->json(['status' => 'error']);
        }
    }
}
