<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controller\{
    SiswaController,
    AuthController,
    GuruController,
    JawabanController
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

class SoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->keywords;
        $request->page;
        $request->angket;
        $soals = Soal::leftjoin('angket', 'angket.id', '=', 'angket_id')
        ->leftjoin('jawabans', 'jawabans.soal_id', '=', 'soals.id')
        ->where('angket.nama_angket', 'like', '%'.strtolower($request->angket)."%")
        ->orderBy("soals.id", 'desc')
        ->paginate($request->perpage, [
            'angket.id',
            'soals.angket_id',
            'angket.nama_angket',
            'soals.id',
            'nama_soal',
            'jawabans.jawaban',
        ]);
        return response()->json([
            'status' => 'success',
            'perpage' => $request->perpage,
            'role' => $request->role,
            'message' => 'sukses menampilkan data',
            'data' => $soals,
        ]);
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
        $rules = array(
            'nama_soal' => 'required|string|max:255',
            'angket_id' => 'required|integer|max:3',
        );

        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $soals = Soal::create([
                'nama_soal' => $request->nama_soal,
                'angket_id' => $request->angket_id,
            ]);

            $resultJawaban = [
                'a' => $request->a,
                'b' => $request->b,
                'c' => $request->c,
                'd' => $request->d,
            ];

            $jawaban = Jawaban::create([
                'soal_id'   => $soals->id,
                'jawaban'   => $resultJawaban,
            ]);
            return response()->json([
                'status' => 'success',
                'perpage' => $request->perpage,
                'message' => 'sukses menampilkan data',
                'data' => $soals,
            ]);
           
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $soal = Soal::where('id', $id)->first();
        $soal->angket_id = $request->angket_id;
        $soal->nama_soal = $request->nama_soal;
        
        if($soal->save()){
            return response()->json([
                "status" => "success",
                "message" => 'Berhasil Menyimpan Data',
                'data'  => $soal,
            ]);
        }else{
            return response()->json([
                "status" => "failed",
                "message" => 'Gagal Menyimpan Data'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hapus = Soal::where("id", $id)->delete();   
        if($hapus){
            return response()->json([
                "status" => "success",
                "message" => 'berhasil menghapus data'
            ]);
        }else{
            return response()->json([
                "status" => "failed",
                "message" => 'gagal menghapus data'
            ]);
        }
    }
}
