<?php

namespace App\Http\Controllers\dashboard\masterData\randaKabilasa;

use App\Http\Controllers\Controller;
use App\Models\SoalMencegahMalnutrisi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SoalMencegahMalnutrisiController extends Controller
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
            $data = SoalMencegahMalnutrisi::orderBy('urutan', 'asc')->get();
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button id="btn-edit" class="btn btn-warning btn-sm me-1 text-white" value="' . $row->id . '" ><i class="fas fa-edit"></i></button><button id="btn-delete" class="btn btn-danger btn-sm me-1 text-white" value="' . $row->id . '" ><i class="fas fa-trash"></i></button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('dashboard.pages.masterData.randaKabilasa.soalMencegahMalnutrisi');
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
                'urutan' => ['required', Rule::unique('soal_mencegah_malnutrisi')->withoutTrashed(), 'numeric'],
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

        $soalMencegahMalnutrisi = new SoalMencegahMalnutrisi();
        $soalMencegahMalnutrisi->urutan = $request->urutan;
        $soalMencegahMalnutrisi->soal = $request->soal;
        $soalMencegahMalnutrisi->skor_ya = $request->skor_ya;
        $soalMencegahMalnutrisi->skor_tidak = $request->skor_tidak;
        $soalMencegahMalnutrisi->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SoalAssessment1  $soalAssessment1
     * @return \Illuminate\Http\Response
     */
    public function show(SoalMencegahMalnutrisi $soalMencegahMalnutrisi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SoalAssessment1  $soalAssessment1
     * @return \Illuminate\Http\Response
     */
    public function edit(SoalMencegahMalnutrisi $soalMencegahMalnutrisi)
    {
        return response()->json($soalMencegahMalnutrisi);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SoalAssessment1  $soalAssessment1
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SoalMencegahMalnutrisi $soalMencegahMalnutrisi)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'urutan' => ['required', Rule::unique('soal_mencegah_malnutrisi')->ignore($soalMencegahMalnutrisi->id)->withoutTrashed(), 'numeric'],
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

        $soalMencegahMalnutrisi->urutan = $request->urutan;
        $soalMencegahMalnutrisi->soal = $request->soal;
        $soalMencegahMalnutrisi->skor_ya = $request->skor_ya;
        $soalMencegahMalnutrisi->skor_tidak = $request->skor_tidak;
        $soalMencegahMalnutrisi->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SoalAssessment1  $soalAssessment1
     * @return \Illuminate\Http\Response
     */
    public function destroy(SoalMencegahMalnutrisi $soalMencegahMalnutrisi)
    {
        $soalMencegahMalnutrisi->delete();
        return response()->json(['status' => 'success']);
    }
}
