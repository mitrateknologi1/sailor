<?php

namespace App\Http\Controllers\dashboard\masterData\momsCare;

use App\Http\Controllers\Controller;
use App\Models\SoalDeteksiDini;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SoalDeteksiDiniController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SoalDeteksiDini::orderBy('urutan', 'asc')->get();
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button id="btn-edit" class="btn btn-warning btn-sm me-1 text-white" value="' . $row->id . '" ><i class="fas fa-edit"></i></button><button id="btn-delete" class="btn btn-danger btn-sm me-1 text-white" value="' . $row->id . '" ><i class="fas fa-trash"></i></button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('dashboard.pages.masterData.momsCare.soalDeteksiDini');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
                'urutan' => ['required', Rule::unique('soal_deteksi_dini')->withoutTrashed(), 'numeric'],
                'soal' => ['required'],
                'skor_ya' => ['required', 'numeric'],
                'skor_tidak' => ['required', 'numeric'],
            ],
            [
                'urutan.required' => 'Urutan harus diisi',
                'urutan.unique' => 'Urutan sudah ada',
                'urutan.numeric' => 'Urutan harus berupa angka',
                'soal.required' => 'Soal harus diisi',
                'skor_ya.required' => 'Skor Ya harus diisi',
                'skor_tidak.required' => 'Skor Tidak harus diisi',
                'skor_ya.numeric' => 'Skor Ya harus berupa angka',
                'skor_tidak.numeric' => 'Skor Tidak harus berupa angka',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $soalDeteksiDini = new SoalDeteksiDini();
        $soalDeteksiDini->urutan = $request->urutan;
        $soalDeteksiDini->soal = $request->soal;
        $soalDeteksiDini->skor_ya = $request->skor_ya;
        $soalDeteksiDini->skor_tidak = $request->skor_tidak;
        $soalDeteksiDini->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SoalDeteksiDini  $soalDeteksiDini
     * @return \Illuminate\Http\Response
     */
    public function show(SoalDeteksiDini $soalDeteksiDini)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SoalDeteksiDini  $soalDeteksiDini
     * @return \Illuminate\Http\Response
     */
    public function edit(SoalDeteksiDini $soalDeteksiDini)
    {
        return response()->json($soalDeteksiDini);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SoalDeteksiDini  $soalDeteksiDini
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SoalDeteksiDini $soalDeteksiDini)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'urutan' => ['required', Rule::unique('soal_deteksi_dini')->ignore($soalDeteksiDini->id)->withoutTrashed(), 'numeric'],
                'soal' => ['required'],
                'skor_ya' => ['required', 'numeric'],
                'skor_tidak' => ['required', 'numeric'],
            ],
            [
                'urutan.required' => 'Urutan harus diisi',
                'urutan.unique' => 'Urutan sudah ada',
                'urutan.numeric' => 'Urutan harus berupa angka',
                'soal.required' => 'Soal harus diisi',
                'skor_ya.required' => 'Skor Ya harus diisi',
                'skor_tidak.required' => 'Skor Tidak harus diisi',
                'skor_ya.numeric' => 'Skor Ya harus berupa angka',
                'skor_tidak.numeric' => 'Skor Tidak harus berupa angka',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $soalDeteksiDini->urutan = $request->urutan;
        $soalDeteksiDini->soal = $request->soal;
        $soalDeteksiDini->skor_ya = $request->skor_ya;
        $soalDeteksiDini->skor_tidak = $request->skor_tidak;
        $soalDeteksiDini->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SoalDeteksiDini  $soalDeteksiDini
     * @return \Illuminate\Http\Response
     */
    public function destroy(SoalDeteksiDini $soalDeteksiDini)
    {
        $soalDeteksiDini->delete();
        return response()->json(['status' => 'success']);
    }
}
