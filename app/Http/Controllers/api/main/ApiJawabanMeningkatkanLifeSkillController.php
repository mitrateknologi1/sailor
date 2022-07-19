<?php

namespace App\Http\Controllers\api\main;

use App\Http\Controllers\Controller;
use App\Models\JawabanMeningkatkanLifeSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiJawabanMeningkatkanLifeSkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $randaKabilasaId = $request->randa_kabilasa_id;
        $jawabanMeningkatkanLifeSkill = new JawabanMeningkatkanLifeSkill();

        if ($randaKabilasaId) {
            $jawabanMeningkatkanLifeSkill->where("randa_kabilasa_id", $randaKabilasaId);
        }

        return $jawabanMeningkatkanLifeSkill->get();
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
                "*.randa_kabilasa_id" => 'required|exists:randa_kabilasa,id',
                "*.soal_id" => 'required|exists:soal_meningkatkan_life_skill,id',
                "*.jawaban" => 'required',
            ]);

            $field = [];

            foreach ($reqBody as $key => $value) {
                array_push($field, [
                    'id' => Str::uuid()->toString(),
                    'randa_kabilasa_id' => $value->randa_kabilasa_id,
                    'soal_id' => $value->soal_id,
                    'jawaban' => $value->jawaban,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            JawabanMeningkatkanLifeSkill::insert($field);
            return $field;
        } else {
            $request->validate([
                "randa_kabilasa_id" => 'required|exists:randa_kabilasa,id',
                "soal_id" => 'required|exists:soal_meningkatkan_life_skill,id',
                "jawaban" => 'required',
            ]);

            return JawabanMeningkatkanLifeSkill::create($request->all());
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
        return JawabanMeningkatkanLifeSkill::find($id);
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
            "randa_kabilasa_id" => 'required|exists:randa_kabilasa,id',
            "soal_id" => 'required|exists:soal_meningkatkan_life_skill,id',
            "jawaban" => 'required',
        ]);

        $jawabanMeningkatkanLifeSkill = JawabanMeningkatkanLifeSkill::find($id);

        if ($jawabanMeningkatkanLifeSkill) {
            $jawabanMeningkatkanLifeSkill->update($request->all());
            return $jawabanMeningkatkanLifeSkill;
        }

        return response([
            'message' => "Jawaban Meningkatkan Life Skill with id $id doesn't exist"
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
        $randaKabilasaId = $request->randa_kabilasa_id;
        if ($id) {
            $jawabanMeningkatkanLifeSkill = JawabanMeningkatkanLifeSkill::find($id);

            if ($jawabanMeningkatkanLifeSkill) {
                return $jawabanMeningkatkanLifeSkill->delete();
            }
            return response([
                'message' => "Jawaban Meningkatkan Life Skill with id $id doesn't exist"
            ], 400);
        } else if ($randaKabilasaId) {
            $jawabanMeningkatkanLifeSkill = JawabanMeningkatkanLifeSkill::where('randa_kabilasa_id', $randaKabilasaId)->first();

            if ($jawabanMeningkatkanLifeSkill) {
                return JawabanMeningkatkanLifeSkill::where('randa_kabilasa_id', $randaKabilasaId)->delete();
            }
            return response([
                'message' => "Jawaban Meningkatkan Life Skill with randa_kabilasa_id $randaKabilasaId doesn't exist"
            ], 400);
        }
    }
}
