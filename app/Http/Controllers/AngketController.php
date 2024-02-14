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
    Jawaban,
    Angket
};

use Hash;
use Auth;
use Validator;

class AngketController extends Controller
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
        $request->perpage;
        $request->jenis;
        $angket = Angket::leftjoin('users', 'users.id', '=', 'angket.created_by')
        ->orderBy("angket.id", 'desc')
        ->paginate($request->perpage, [
            'angket.id',
            'angket.created_by',
            'angket.updated_by',
            'users.nama_user',
            'angket.nama_angket',
            'angket.keterangan',
        ]);

        return response()->json([
            'status' => 'success',
            'perpage' => $request->perpage,
            'message' => 'sukses menampilkan data',
            'data' => $angket
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
            'nama_angket'=> 'required|string',
            'keterangan'=> 'required|string',
        );

        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $angket = Angket::create([
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'nama_angket' => $request->nama_angket,
                'keterangan' => $request->keterangan,
            ]);

            return response()->json([
                "status" => "success",
                "message" => 'Berhasil Menyimpan Data',
                'data'  => $angket,

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
        $request->perpage;
        $request->page;
        $request->angket;
        $angket = Angket::leftjoin('users', 'users.id', '=', 'angket.created_by')
        ->where('angket.id', $id)
        ->orderBy("angket.id", 'desc')
        ->value("nama_angket");
        
        $soals = Soal::leftjoin('angket', 'angket.id', '=', 'angket_id')
        ->where('soals.angket_id', $id)
        ->orderBy("soals.id", 'desc')
        ->paginate($request->perpage, [
            'soals.angket_id',
            'angket.nama_angket',
            'soals.nomor_soal',
            'soals.id',
            'soal',
        ]);
        return response()->json([
            'status' => 'success',
            'perpage' => $request->perpage,
            'page' => $request->page,
            'role' => $request->role,
            'message' => 'sukses menampilkan data',
            'angket' => $angket,
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
        $angket = Angket::where('id', $id)->first();
        $angket->updated_by =  $user->id;
        $angket->nama_angket =  $request->nama_angket;
        $angket->keterangan =  $request->keterangan;
        
        if($angket->save()){
            return response()->json([
                "status" => "success",
                "message" => 'Berhasil Menyimpan Data',
                'data'  => $angket,
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
        $hapus = Angket::where("id", $id)->delete();   
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
