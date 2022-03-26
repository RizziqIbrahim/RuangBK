<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controller\{
    SiswaController,
    AuthController,
    GuruController,
    SoalController
};
use App\Models\{
    Siswa,
    User,
    Guru,
    Soal,
    Jawaban
};

use Hash;
use Auth;
use Validator;

class JawabanController extends Controller
{
    public function index(Request $request)
    {
        $request->keywords;
        $request->page;
        $jawaban = Jawaban::leftjoin('angket', 'angket.id', '=', 'angket_id')
        ->leftjoin('users', 'users.id', '=', 'user_id')
        ->orderBy("jawabans.created_at", 'desc')
        ->paginate($request->perpage, [
            'jawabans.id',
            'jawabans.angket_id',
            'jawabans.user_id',
            'jawabans.jawaban'
        ]);

        return response()->json([
            'status' => 'success',
            'perpage' => $request->perpage,
            'message' => 'sukses menampilkan data',
            'data' => $jawaban
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $data = array(
            "soal_id" => $request->user_id,
            "jawaban" => $request->jawaban,
        );
        $user = $request->user();
        $getJawaban = Jawaban::where("user_id", $user->id)->get();

        if($getJawaban == ""){
            $jawaban = Jawaban::create([
                'soal' => $request->soal,
                'angket_id' => $request->angket_id,
                'jawaban' => json_encode($data),
                'user_id' => $user->id,
                'kode' =>   $request->kode
            ]);
        }else{
           
        }
        

        return response()->json([
            'status' => 'success',
            'perpage' => $request->perpage,
            'message' => 'sukses menampilkan data',
            'data' => $jawaban,
        ]);
           
    }
}
