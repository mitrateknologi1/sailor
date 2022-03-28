<?php

namespace App\Http\Controllers\dashboard\masterData\deteksiStunting;

use App\Http\Controllers\Controller;
use App\Models\KartuKeluarga;
use App\Models\SoalIbuMelahirkanStunting;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SoalIbuMelahirkanStuntingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SoalIbuMelahirkanStunting::orderBy('urutan', 'asc')->get();
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button id="btn-edit" class="btn btn-warning btn-sm me-1 text-white" value="' . $row->id . '" ><i class="fas fa-edit"></i></button><button id="btn-delete" class="btn btn-danger btn-sm me-1 text-white" value="' . $row->id . '" ><i class="fas fa-trash"></i></button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('dashboard.pages.masterData.deteksiStunting.soalIbuMelahirkanStunting');
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
                'urutan' => ['required', Rule::unique('soal_ibu_melahirkan_stunting')->withoutTrashed(), 'numeric'],
                'soal' => ['required'],
            ],
            [
                'urutan.required' => 'Urutan harus diisi',
                'urutan.unique' => 'Urutan sudah ada',
                'urutan.numeric' => 'Urutan harus berupa angka',
                'soal.required' => 'Soal harus diisi',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $soalIbuMelahirkanStunting = new SoalIbuMelahirkanStunting();
        $soalIbuMelahirkanStunting->urutan = $request->urutan;
        $soalIbuMelahirkanStunting->soal = $request->soal;
        $soalIbuMelahirkanStunting->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SoalIbuMelahirkanStunting  $soalIbuMelahirkanStunting
     * @return \Illuminate\Http\Response
     */
    public function show(SoalIbuMelahirkanStunting $soalIbuMelahirkanStunting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SoalIbuMelahirkanStunting  $soalIbuMelahirkanStunting
     * @return \Illuminate\Http\Response
     */
    public function edit(SoalIbuMelahirkanStunting $soalIbuMelahirkanStunting)
    {
        return response()->json($soalIbuMelahirkanStunting);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SoalIbuMelahirkanStunting  $soalIbuMelahirkanStunting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SoalIbuMelahirkanStunting $soalIbuMelahirkanStunting)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'urutan' => ['required', Rule::unique('soal_ibu_melahirkan_stunting')->ignore($soalIbuMelahirkanStunting->id)->withoutTrashed(), 'numeric'],
                'soal' => ['required'],
            ],
            [
                'urutan.required' => 'Urutan harus diisi',
                'urutan.unique' => 'Urutan sudah ada',
                'urutan.numeric' => 'Urutan harus berupa angka',
                'soal.required' => 'Soal harus diisi',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $soalIbuMelahirkanStunting->urutan = $request->urutan;
        $soalIbuMelahirkanStunting->soal = $request->soal;
        $soalIbuMelahirkanStunting->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SoalIbuMelahirkanStunting  $soalIbuMelahirkanStunting
     * @return \Illuminate\Http\Response
     */
    public function destroy(SoalIbuMelahirkanStunting $soalIbuMelahirkanStunting)
    {
        $soalIbuMelahirkanStunting->delete();
        return response()->json(['status' => 'success']);
    }
}
