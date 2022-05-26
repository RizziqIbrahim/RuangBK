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

    public function getSiswaAkses(Request $request, $id)
    {
        $user = $request->user();
        $request->page;
        $request->perpage;

        $array = Akses::leftjoin('angket', 'angket.id', '=', 'akses.angket_id')
        ->orderBy("akses.id", 'desc')
        ->where("akses.id", $id)
        ->value("user");
        if ($array == "") {
            return response()->json([
                'status' => 'failed',
                'perpage' => $request->perpage,
                'message' => 'Belum ada siswa yang diberi akses pada angket ini',
            ]);
        }else{
            $array = Akses::leftjoin('angket', 'angket.id', '=', 'akses.angket_id')
            ->orderBy("akses.id", 'desc')
            ->where("akses.id", $id)
            ->value("user");
            $userId = json_decode($array)[0];
            $guru_id =  Guru::where('user_id', $user->id)->value("id");
            $siswa = Siswa::leftjoin('users', 'users.id', '=', 'user_id')->leftjoin('gurus', 'gurus.id', '=', 'siswas.guru_id')
            ->where('siswas.guru_id', $user->id)
            ->whereIn('users.id', $userId)
            ->orderBy("siswas.created_at", 'desc')
            ->paginate($request->perpage, [
                'siswas.id',
                'siswas.user_id',
                'siswas.guru_id',
                'gurus.nama_guru',
                'siswas.nisn',
                'siswas.nama_siswa',
                'users.email',
                'users.nomor_telp',
                'siswas.tempat_lahir',      
                'siswas.tanggal_lahir',
                'siswas.foto',
                'siswas.sekolah',
                'siswas.kelas',
                'siswas.npsn',
                'siswas.alamat',
                'siswas.created_at',
            ]);

            return response()->json([
                'status' => 'success',
                'perpage' => $request->perpage,
                'message' => 'sukses menampilkan data',
                'data' => $siswa,
                'user' => $user->id,
                'siswa' => $userId
            ]);
        }
        

        
    }

    public function getSiswa(Request $request, $id)
    {
        $user = $request->user();
        $request->page;
        $request->perpage;
        $array = Akses::leftjoin('angket', 'angket.id', '=', 'akses.angket_id')
        ->orderBy("akses.id", 'desc')
        ->where("akses.id", $id)
        ->value("user");
        $guru_id =  Guru::where('user_id', $user->id)->value("id");
        if ($array == "") {
            $guru_id =  Guru::where('user_id', $user->id)->value("id");
            $siswa = Siswa::leftjoin('users', 'users.id', '=', 'user_id')->leftjoin('gurus', 'gurus.id', '=', 'siswas.guru_id')
            ->where('siswas.guru_id', $user->id)
            ->orderBy("siswas.created_at", 'desc')
            ->paginate($request->perpage, [
                'siswas.id',
                'siswas.user_id',
                'siswas.guru_id',
                'gurus.nama_guru',
                'siswas.nisn',
                'siswas.nama_siswa',
                'users.email',
                'users.nomor_telp',
                'siswas.tempat_lahir',      
                'siswas.tanggal_lahir',
                'siswas.foto',
                'siswas.sekolah',
                'siswas.kelas',
                'siswas.npsn',
                'siswas.alamat',
                'siswas.created_at',
            ]);
            return response()->json([
                'status' => 'success',
                'perpage' => $request->perpage,
                'message' => 'sukses menampilkan data',
                'data' => $siswa,
                'user' => $user->id,
            ]);
        }else{
            $userId = json_decode($array)[0];
            $guru_id =  Guru::where('user_id', $user->id)->value("id");
            $siswa = Siswa::leftjoin('users', 'users.id', '=', 'user_id')->leftjoin('gurus', 'gurus.id', '=', 'siswas.guru_id')
            ->where('siswas.guru_id', $user->id)
            ->whereNotIn('users.id', $userId)
            ->orderBy("siswas.created_at", 'desc')
            ->paginate($request->perpage, [
                'siswas.id',
                'siswas.user_id',
                'siswas.guru_id',
                'gurus.nama_guru',
                'siswas.nisn',
                'siswas.nama_siswa',
                'users.email',
                'users.nomor_telp',
                'siswas.tempat_lahir',      
                'siswas.tanggal_lahir',
                'siswas.foto',
                'siswas.sekolah',
                'siswas.kelas',
                'siswas.npsn',
                'siswas.alamat',
                'siswas.created_at',
            ]);
            return response()->json([
                'status' => 'success',
                'perpage' => $request->perpage,
                'message' => 'sukses menampilkan data',
                'data' => $siswa,
                'user' => $user->id,
                'siswa' => $userId
            ]);
        }

        return response()->json([
            'status' => 'success',
            'perpage' => $request->perpage,
            'message' => 'sukses menampilkan data',
            'data' => $siswa,
            'user' => $user->id,
            'siswa' => $userId
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $request->siswa;
        $request->page;
        $request->perpage;
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
                    // 'user' => ($data),
                    'user' => "",
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

    public function storeSiswaAkses(Request $request, $id)
    {

        $user = $request->user();
        $request->siswa;
        $request->page;
        $request->perpage;
        $siswa = Siswa::leftjoin('users', 'users.id', '=', 'user_id')->leftjoin('gurus', 'gurus.id', '=', 'siswas.guru_id')
        ->where('siswas.guru_id', $user->id)
        ->where('siswas.nama_siswa', 'like', '%'.strtolower($request->siswa)."%")
        ->orderBy("siswas.created_at", 'desc')
        ->paginate($request->perpage, [
            'siswas.id',
            'siswas.user_id',
            'siswas.guru_id',
            'gurus.nama_guru',
            'siswas.nisn',
            'siswas.nama_siswa',
            'users.email',
            'users.nomor_telp',
            'siswas.tempat_lahir',  
            'siswas.tanggal_lahir',
            'siswas.foto',
            'siswas.sekolah',
            'siswas.kelas',
            'siswas.npsn',
            'siswas.alamat',
            'siswas.created_at' 
        ]);

        $array = Akses::leftjoin('angket', 'angket.id', '=', 'akses.angket_id')
        ->orderBy("akses.id", 'desc')   
        ->where("akses.id", $request->akses_id)
        ->value("user");

        if ($array == "") {
            $userId = array($id);
        }else{
            $userId = array(json_decode($array))[0][0];
            array_push($userId, $id);
        }
        
        
        $akses = Akses::where('id', $request->akses_id)->first();
        $akses->user = json_encode([$userId]);
        $akses->update();

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
        
        // $array = Akses::leftjoin('angket', 'angket.id', '=', 'akses.angket_id')
        // ->orderBy("akses.id", 'desc')
        // ->value("user");

        // $user_id = json_decode($array)[0];

        // // for ($i=0; $i < $user_id ; $i++) { 
        // //     $user_satuan = $user_id[$i];
        // // }
        // if(in_array($user->id, $user_id)){
            $id = strtolower($user->id. '\"');
            // return $id;
            $akses = Akses::leftjoin('angket', 'angket.id', '=', 'akses.angket_id')
            ->orderBy("akses.id", 'desc')
            ->where("user",  'like', '%'. $id ."%")
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
        // }else{
        //     return "anda tidak memiliki akses ";
        // }
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
    