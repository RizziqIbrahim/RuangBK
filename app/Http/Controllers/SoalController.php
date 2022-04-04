<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SoalImport;
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
        ->where('angket.nama_angket', 'like', '%'.strtolower($request->angket)."%")
        ->orderBy("soals.id", 'desc')
        ->paginate($request->perpage, [
            'soals.angket_id',
            'angket.nama_angket',
            'soals.id',
            'soals.soal',
            'soals.created_by',
            'soals.updated_by',
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
        $user = $request->user();
        $rules = array(
            'soal' => 'required|string|max:255',
            'angket_id' => 'required|integer',
        );

        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $soals = Soal::create([
                'soal' => $request->soal,
                'angket_id' => $request->angket_id,
                'created_by' => $user->id,
                'updated_by' => $user->id,
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
    public function show(Request $request, $id)
    {
        $request->keywords;
        $request->page;
        $request->angket;
        $soals = Soal::leftjoin('angket', 'angket.id', '=', 'angket_id')
        ->where('soals.id', $id)
        ->orderBy("soals.id", 'desc')
        ->paginate($request->perpage, [
            'soals.angket_id',
            'angket.nama_angket',
            'soals.id',
            'soals.soal',
            'soals.created_by',
            'soals.updated_by',
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
        $user = $request->user();
        $soal = Soal::where('id', $id)->first();
        $soal->angket_id = $request->angket_id;
        $soal->soal = $request->soal;
        $soal->updated_by = $user->id;
        

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

    public function import(Request $request)
    {
        $soal = Excel::import(new SoalImport, $request->file('soal')->store('temp'));
        if($soal){
            return response()->json([
                'message'   => 'Success',
                // 'roles' => $roles[0],
            ], 200);
        }else{
            return response()->json([
                'message'   => 'Gagal',
            ], 200);
        }
    }
}
