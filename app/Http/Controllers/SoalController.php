<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controller\{
    SiswaController,
    AuthController,
    GuruController,
    
};
use App\Models\{
    Siswa,
    User,
    Guru,
    Soal
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
        $request->role;
        $soals = Soal::where('jenis_soal', 'like', '%'.strtolower($request->keywords)."%")
        ->where('role', 'like', '%'.strtolower($request->role)."%")
        ->orderBy("created_at", 'desc')
        ->paginate($request->perpage, [
            'soals.id',
            'soals.jenis_soal',
            'soals.content',
            'soals.jawaban1',
            'soals.jawaban2',
            'soals.jawaban3',
            'soals.jawaban4',
            'soals.cjawaban5'
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
            'content' => 'required|string',
            'jawaban1' => 'required|intiger',
            'jawaban2' => 'required|intiger',
            'jawaban3' => 'required|intiger',
            'jawaban4' => 'required|intiger',
            'jawaban5' => 'required|intiger',
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
                'jawaban1' => $request->jawaban1,
                'jawaban1' => $request->jawaban2,
                'jawaban1' => $request->jawaban3,
                'jawaban1' => $request->jawaban4,
                'jawaban1' => $request->jawaban5,
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
        //
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
