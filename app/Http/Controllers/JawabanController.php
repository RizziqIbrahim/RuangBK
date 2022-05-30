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
    Jawaban,
    Akses,
    Angket
};

use Hash;
use Auth;
use Validator;
use App\Exports\JawabanExport;
use Maatwebsite\Excel\Facades\Excel;

class JawabanController extends Controller
{
    public function index(Request $request)
    {
        $request->keywords;
        $request->page;
        $request->perpage;
        $jawaban = Jawaban::leftjoin('angket', 'angket.id', '=', 'angket_id')
        ->leftjoin('users', 'users.id', '=', 'user_id')
        ->orderBy("jawabans.created_at", 'desc')
        ->paginate($request->perpage, [
            'jawabans.id',
            'jawabans.angket_id',
            'jawabans.user_id',
            'jawabans.jawaban',
            'jawabans.kode'
        ]);

        return response()->json([
            'status' => 'success',
            'perpage' => $request->perpage,
            'message' => 'sukses menampilkan data',
            'data' => $jawaban
        ]);
    }

    public function checkjawaban(Request $request, $kode)
    {
        $user = $request->user();
        $angket_id = Akses::leftjoin('angket', 'angket.id', '=', 'akses.angket_id')
        ->where("akses.kode", $kode )->value("angket_id");

        $jumlahsoal = Soal::where("angket_id", $angket_id)->count();
        
        $user = $request->user();
        $getJawaban = Jawaban::where("user_id", $user->id)->where("kode", $kode)->value("jawaban");
        $arrayJawaban = json_decode($getJawaban, true);
        $jumlahJawaban = count(collect($arrayJawaban));
        
        $start_at = Akses::leftjoin('angket', 'angket.id', '=', 'akses.angket_id')
        ->where("akses.kode", $kode )->value("start_at");
        if ($start_at <= Carbon::now()->format("Y-m-d")) {
            if($getJawaban == ""){
                $status = "belum mengerjakan";
            }elseif($jumlahJawaban < $jumlahsoal){
                $status = "belum selesai";
            }else{
                $status = "sudah mengerjakan";
            }
        }elseif ($start_at > Carbon::now()->format("Y-m-d")) {
            $status = "belum saatnya mengerjakan";
        }

        $finish_at = Akses::leftjoin('angket', 'angket.id', '=', 'akses.angket_id')
        ->where("akses.kode", $kode )->value("finish_at");
        
        if ($finish_at <= Carbon::now()->format("Y-m-d")) {
            $status = "terlambat";
        }
        

        return response()->json([
            'status' => $status,
            'perpage' => $request->perpage,
            'message' => 'sukses menampilkan data',
            'jumlah_soal' => $jumlahsoal,
            'jumlah_jawaban' => $jumlahJawaban,
            'jawaban' => $arrayJawaban,
            "angket_id" => $angket_id
        ]);
    }


    public function store(Request $request, $kode)
    {
        $user = $request->user();
        $angket_id = Akses::leftjoin('angket', 'angket.id', '=', 'akses.angket_id')
        ->where("akses.kode", $kode )->value("angket_id");


        $jumlahsoal = Soal::where("angket_id", $angket_id)->count();
        for ($i=0; $i < count($request->nomor_soal); $i++) { 
            $data[$i] = [
                "nomor_soal" => $request->nomor_soal[$i],
                "jawaban" => $request->jawaban[$i],
            ];    
        }
        $user = $request->user();
        $getJawaban = Jawaban::where("user_id", $user->id)->where("kode", $kode)->value("jawaban");
        $arrayJawaban = json_decode($getJawaban, true);
        $jumlahJawaban = count(collect($arrayJawaban));
        if($jumlahJawaban < $jumlahsoal){
            $jawaban = Jawaban::create([
                'angket_id' => $angket_id,
                'jawaban' => json_encode($data),
                'user_id' => $user->id,
                'kode' =>   $kode
            ]);
            $status = "success";
        }else{
            $status = "mohon maaf anda tidak bisa mengerjakan";
            $jawaban = "";
        }
        
        return response()->json([
            'status' => $status,
            'perpage' => $request->perpage,
            'message' => 'sukses menampilkan data',
            'data' => $jawaban,
            'jumlah_soal' => $jumlahsoal,
            'jumlah_jawaban' => $jumlahJawaban,
        ]);
           
    }

    public function showjawabanperuser(Request $request, $id)
    {
        $request->keywords;
        $request->page;
        $request->perpage;
        $user = $request->user();
        $jawaban = Jawaban::leftjoin('angket', 'angket.id', '=', 'angket_id')
        ->leftjoin('users', 'users.id', '=', 'user_id')
        ->where("jawabans.user_id", $user->id)
        ->where("jawabans.id", $id)
        ->orderBy("jawabans.created_at", 'asc')
        ->paginate($request->perpage, [
            'jawabans.id',
            'jawabans.angket_id',
            'jawabans.user_id',
            'jawabans.jawaban'
        ]);
  
        $detailJawaban = Jawaban::leftjoin('angket', 'angket.id', '=', 'angket_id')
        ->leftjoin('users', 'users.id', '=', 'user_id')
        ->where("jawabans.user_id", $user->id)  
        ->where("jawabans.id", $id)
        ->orderBy("jawabans.created_at", 'asc')
        ->value("jawaban");

        return response()->json([
            'status' => 'success',
            'perpage' => $request->perpage,
            'message' => 'sukses menampilkan data',
            'data' => $jawaban,
            "jawaban" => json_decode($detailJawaban, true)
        ]);
    }

    public function show(Request $request, $id)
    {
        $request->keywords;
        $request->page;
        $request->perpage;
        $jawaban = Jawaban::leftjoin('angket', 'angket.id', '=', 'angket_id')
        ->leftjoin('users', 'users.id', '=', 'user_id')
        ->where("jawabans.id", $id)
        ->orderBy("jawabans.created_at", 'asc')
        ->paginate($request->perpage, [
            'jawabans.id',
            'jawabans.angket_id',
            'jawabans.user_id',
            'jawabans.jawaban'
        ]);

        $detailJawaban = Jawaban::leftjoin('angket', 'angket.id', '=', 'angket_id')
        ->leftjoin('users', 'users.id', '=', 'user_id')
        ->where("jawabans.id", $id)
        ->orderBy("jawabans.created_at", 'asc')
        ->value("jawaban");

        return response()->json([
            'status' => 'success',
            'perpage' => $request->perpage,
            'message' => 'sukses menampilkan data',
            'data' => $jawaban,
            "jawaban" => json_decode($detailJawaban, true)
        ]);
    }
    
    public function export($id)
	{
        $siswa_id = Jawaban::leftjoin('angket', 'angket.id', '=', 'angket_id')
        ->leftjoin('users', 'users.id', '=', 'user_id')
        ->where("jawabans.id", $id)
        ->orderBy("jawabans.created_at", 'asc')
        ->value("user_id");

        $nama_user = User::where('id', $siswa_id)
        ->orderBy("created_at", 'desc')
        ->value("nama_user");

        $angket_id = Jawaban::leftjoin('angket', 'angket.id', '=', 'angket_id')
        ->leftjoin('users', 'users.id', '=', 'user_id')
        ->where("jawabans.id", $id)
        ->orderBy("jawabans.created_at", 'asc')
        ->value("angket_id");

        $angket = Angket::where("id", $angket_id)
        ->orderBy("angket.id", 'desc')
        ->value("nama_angket"); 

        $detailJawaban = Jawaban::leftjoin('angket', 'angket.id', '=', 'angket_id')
        ->leftjoin('users', 'users.id', '=', 'user_id')
        ->where("jawabans.id", $id)
        ->orderBy("jawabans.created_at", 'asc')
        ->value("jawaban");
        $data = json_decode($detailJawaban, true);
        // return $data;
		return Excel::download(new JawabanExport($id, $data), 'jawaban-export-' . $nama_user .  "-" .$angket  .'.xlsx');
	}

    // $start_at = Akses::leftjoin('angket', 'angket.id', '=', 'akses.angket_id')
    //     ->where("akses.kode", $kode )->value("start_at");

        
}
