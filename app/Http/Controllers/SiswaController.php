<?php

namespace App\Http\Controllers;

use App\Http\Controllers\{
    AuthController,
    CloudinaryStorage,
};
use App\Models\{
    Siswa,
    User,

};

use Illuminate\Http\Request;
use Hash;
use Auth;
use Validator;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $request->keywords;
        $request->page;
        $siswa = Siswa::leftjoin('users', 'users.id', '=', 'user_id')->where('users.nama_user', 'like', '%'.strtolower($request->keywords)."%")
        ->orderBy("siswas.created_at", 'desc')
        ->paginate($request->perpage, [
            'siswas.id',
            'siswas.user_id',
            'users.status',
            'siswas.nisn',
            'siswas.nama_siswa',
            'users.email',
            'users.nomor_telp',
            'siswas.tempat_lahir',      
            'siswas.tanggal_lahir',
            'siswas.foto',
            'siswas.alamat',
            'siswas.created_at' 
        ]);

        return response()->json([
            'status' => 'success',
            'perpage' => $request->perpage,
            'message' => 'sukses menampilkan data',
            'data' => $siswa,
            'user' => $user->id
        ]);
    }


    // public function store(Request $request)
    // {
        
    //     $user = $request->user();
    //     {
    //         $rules = array(
    //             'nisn' => 'required|string|max:16',
    //             'nama_siswa' => 'required|string|max:20',
    //             'tempat_lahir' => 'required|string|max:255',
    //             'tanggal_lahir' => 'required|date',
    //             'alamat' => 'required|string|max:255',
    //             'foto' => 'required',
    //         );
    
    //         $cek = Validator::make($request->all(),$rules);
    
    //         if($cek->fails()){
    //             $errorString = implode(",",$cek->messages()->all());
    //             return response()->json([
    //                 'message' => $errorString
    //             ], 401);
    //         }else{
    //             $image  = $request->file('foto');
    //             $result = CloudinaryStorage::upload($image->getRealPath(), $image->getClientOriginalName());
    //                 $siswa = Siswa::create([
    //                     'user_id' => $user->id,
    //                     'nisn' => $request->nisn,
    //                     'nama_siswa' => $request->nama_siswa,
    //                     'tempat_lahir' => $request->tempat_lahir,
    //                     'tanggal_lahir' => $request->tanggal_lahir,
    //                     'alamat' => $request->alamat,
    //                     'foto' => $result,
    //                 ]);
        
    //             return response()->json([
    //                 "status" => "success",
    //                 "message" => 'Berhasil Menyimpan Data',
    //             ]);
    //         }
    
    //     }
    // }   


    public function show($id)
    {
        $siswa = Siswa::where('id', $id)->first(); 

        return response()-> json([
            'data' => $siswa
        ]);
    }

    public function update(Request $request, $id)
    {
        $file   = $request->file('foto');
        // return $request;
        $user = $request->user();
        $image = Siswa::where('user_id', $user->id)->value("foto");
        $result = CloudinaryStorage::replace($image, $file->getRealPath(), $file->getClientOriginalName());

        $user = $request->user();
        $siswa = Siswa::where('user_id', $user->id)->first();
        // $siswa->user_id = $user->id;
        $siswa->nisn = $request-> nisn;
        $siswa->nama_siswa = $request->nama_siswa;
        $siswa->tempat_lahir = $request->tempat_lahir;
        $siswa->tanggal_lahir = $request->tanggal_lahir;
        $siswa->alamat = $request->alamat;
        $siswa->foto = $result;

        
        if($siswa->save()){
            return response()->json([
                "status" => "success",
                "message" => 'Berhasil Menyimpan Data'
            ]);
        }else{
            return response()->json([
                "status" => "failed",
                "message" => 'Gagal Menyimpan Data'
            ]);
        }
    }
    
    public function npsn(Request $request, $id)
    {
        $user = $request->user();
        $siswa = Siswa::where('user_id', $user->id)->first();
        $siswa->npsn = $request->npsn;
        
        if($siswa->save()){
            return response()->json([
                "status" => "success",
                "message" => 'Berhasil Menyimpan Data'
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
        try {
            $id = explode(",", $id);
            Siswa::whereIn('id', $id)->delete();
            return response()->json(["status" => "Success","message" => "Berhasil Menghapus Data"]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
  
}