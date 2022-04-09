<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controller\{
    SiswaController,
    AuthController,
    GuruController,
    JawabanController,
    SoalController
};
use App\Models\{
    Siswa,
    User,
    Guru,
    Soal,
    Jawaban,
    Angket,
    Akses
};

use Hash;
use Auth;
use Validator;

class AksesController extends Controller
{
    public function index(Request $request)
    {
        $request->keywords;
        $request->page;
        $request->perpage;
        $request->jenis;
        $akses = Akses::leftjoin('angket', 'angket.id', '=', 'akses.angket_id')
        ->orderBy("akses.id", 'desc')
        ->paginate($request->perpage, [
            'akses.id',
            'akses.angket_id',
            'angket.nama_angket',
            'akses.time',
            'akses.start_at',
            'akses.finish_at',
            'akses.kode',
        ]);

        return response()->json([
            'status' => 'success',
            'perpage' => $request->perpage,
            'message' => 'sukses menampilkan data',
            'data' => $akses,
        ]);
    }

    public function store(Request $request)
    {
        for ($i=0; $i < count($request->user_id); $i++) { 
            $data = array($request->user_id,);
                
                
        }

        $user = $request->user();
        $rules = array(
            'time'=> 'required|string',
            'start_at'=> 'required|string',
            'finish_at'=> 'required|string',
        );

        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
                $akses = Akses::create([
                    'angket_id' => $request->angket_id,
                    'user' => json_encode($data),
                    'time' => $request->time,
                    'start_at' => $request->start_at,
                    'finish_at' => $request->finish_at,
                    'open_by' => $user->id,
                    'kode' => uniqid(),
                ]);
            }
            return response()->json([
                "status" => "success",
                "message" => 'Berhasil Menyimpan Data',
                'data'  => $akses,
            ]);
    }

    public function getAkses(Request $request)
    {
        $request->keywords;
        $request->page;
        $request->perpage;
        $request->jenis;
        $user = $request->user();
        
        $array = Akses::leftjoin('angket', 'angket.id', '=', 'akses.angket_id')
        ->orderBy("akses.id", 'desc')->first()
        ->value("user");

        $user_id = json_decode($array)[0];

        // for ($i=0; $i < $user_id ; $i++) { 
        //     $user_satuan = $user_id[$i];
        // }
        if(in_array($user->id, $user_id)){
            $akses = Akses::leftjoin('angket', 'angket.id', '=', 'akses.angket_id')
            ->orderBy("akses.id", 'desc')
            ->paginate($request->perpage, [
                'akses.id',
                'akses.angket_id',
                'angket.nama_angket',
                'angket.keterangan',
                'akses.user',
                'akses.time',
                'akses.start_at',
                'akses.finish_at',
                'akses.kode',
            ]);
            return response()->json([
                'status' => 'success',
                'perpage' => $request->perpage,
                'message' => 'sukses menampilkan data',
                'data' => $akses,
            ]);
        }
    }

    public function show(Request $request, $id)
    {
        $request->keywords;
        $request->page;
        $request->perpage;
        $request->jenis;
        $user = $request->user();

        $array = Akses::leftjoin('angket', 'angket.id', '=', 'akses.angket_id')
        ->orderBy("akses.id", 'desc')
        ->where("akses.id", $id)
        ->value("user");

        $user_id = json_decode($array)[0];

        // for ($i=0; $i < $user_id ; $i++) { 
        //     $user_satuan = $user_id[$i];
        // }
        if(in_array($user->id, $user_id)){
            $akses = Akses::leftjoin('angket', 'angket.id', '=', 'akses.angket_id')
            ->where('akses.id', $id)
            ->orderBy("akses.id", 'desc')
            ->paginate($request->perpage, [
                'akses.id',
                'akses.angket_id',
                'angket.nama_angket',
                'angket.keterangan',
                'akses.user',
                'akses.time',
                'akses.start_at',
                'akses.finish_at',
                'akses.kode',
            ]);
            return response()->json([
                'status' => 'success',
                'perpage' => $request->perpage,
                'message' => 'sukses menampilkan data',
                'data' => $akses,
                'user' => json_decode($array)
            ]);
            
        }else{
            $akses = null;   
            return response()->json([
                'status' => 'success',
                'perpage' => $request->perpage,
                'message' => 'sukses menampilkan data',
                'data' => $akses,
                'user' => json_decode($array)
            ]);
        }

    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        $akses = Akses::where('id', $id)->first();
        $akses->angket_id = $request->angket_id;
        $akses->user = $request->user;
        $akses->time = $request->time;
        $akses->start_at = $request->start_at;
        $akses->finish_at = $request->finish_at;
        $akses->open_by = $user->id;
        $akses->kode = $request->kode;
        
        if($akses->save()){
            return response()->json([
                "status" => "success",
                "message" => 'Berhasil Menyimpan Data',
                'data'  => $akses,
            ]);
        }else{
            return response()->json([
                "status" => "failed",
                "message" => 'Gagal Menyimpan Data'
            ]);
        }
    }

    public function destroy($id)
    {
        $hapus = Akses::where("id", $id)->delete();   
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
