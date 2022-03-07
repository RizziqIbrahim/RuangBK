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
        $request->jenis;
        $soals = Soal::leftjoin('categories', 'categories.id', '=', 'category_id')->where('categories.nama_category', 'like', '%'.strtolower($request->jenis)."%")
        ->orderBy("soals.id", 'desc')
        ->paginate($request->perpage, [
            'soals.id',
            'soals.jenis_soal',
            'soals.content',
            'soals.category_id',
        ]);

        return response()->json([
            'status' => 'success',
            'perpage' => $request->perpage,
            'role' => $request->role,
            'message' => 'sukses menampilkan data',
            'data' => $soals
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
            'jenis_soal' => 'required|string|max:255',
            'category_id' => 'required|integer|max:2',
            'content' => 'required|string|max:255',
        );

        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $soals = Soal::create([
                'jenis_soal' => $request->jenis_soal,
                'content' => $request->content,
                'category_id' => $request->category_id,
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
        $soal->jenis_soal = $request->jenis_soal;
        $soal->content = $request->content;
        $soal->category_id = $request->category_id;
        
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
        //
    }
}
