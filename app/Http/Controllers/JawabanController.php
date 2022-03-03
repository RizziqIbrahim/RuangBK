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
        $jawaban = Jawaban::leftjoin('soals', 'soals.id', '=', 'soal_id')
        ->orderBy("created_at", 'desc')
        ->paginate($request->perpage, [
            'jawaban.id',
            'jawaban.soal_id',
            'soals.content',
            'jawaban.ya',
            'jawaban.tidak',
        ]);

        return response()->json([
            'status' => 'success',
            'perpage' => $request->perpage,
            'message' => 'sukses menampilkan data',
            'data' => $jawaban
        ]);
    }
}
