<?php

namespace App\Http\Controllers;

use App\Http\Controllers\{
    AuthController,
    CloudinaryStorage,
    SiswaController
};
use App\Models\{
    Siswa,
    User,
    Guru,
    Angket

};

use Illuminate\Http\Request;
use Hash;
use Auth;
use Validator;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $request->siswa;
        $request->page;
        $request->perpage;
        $siswa = Siswa::leftjoin('users', 'users.id', '=', 'user_id')->leftjoin('gurus', 'gurus.id', '=', 'siswas.guru_id')
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

        return response()->json([
            'status' => 'success',
            'perpage' => $request->perpage,
            'message' => 'sukses menampilkan data',
            'data' => $siswa,
            'user' => $user->id
        ]);
    }

    public function getSiswa(Request $request)
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

        return response()->json([
            'status' => 'success',
            'perpage' => $request->perpage,
            'message' => 'sukses menampilkan data',
            'data' => $siswa,
            'user' => $user->id
        ]);
    }

    public function jumlah(Request $request)
    {
        $user = $request->user();
        $request->siswa;
        $request->page;
        $request->perpage;
        $siswa = Siswa::leftjoin('users', 'users.id', '=', 'user_id')->leftjoin('gurus', 'gurus.id', '=', 'siswas.guru_id')
        ->where('siswas.guru_id', $user->id)
        ->where('siswas.nama_siswa', 'like', '%'.strtolower($request->siswa)."%")
        ->orderBy("siswas.created_at", 'desc')
        ->count();

        $angket = Angket::leftjoin('users', 'users.id', '=', 'angket.created_by')
        ->orderBy("angket.id", 'desc')
        ->count();

        return response()->json([
            'status' => 'success',
            'perpage' => $request->perpage,
            'message' => 'sukses menampilkan data',
            'siswa' => $siswa,
            'angket' => $angket,
            'user' => $user->id
        ]);
    }

    public function registerUser(Request $request)
    {
        $guru = $request->user();
        $guruProfile = Guru::where('user_id', $guru->id)->leftjoin('users', 'users.id', '=', 'user_id')->first([
            'gurus.id',
            'gurus.user_id',
            'users.role',
            'users.status',
            'gurus.npsn',
            'gurus.nama_guru',
            'users.email',
            'gurus.tempat_lahir',
            'gurus.tanggal_lahir',
            'users.nomor_telp',
            'gurus.foto',
            'gurus.alamat',
            'gurus.sekolah',
            'gurus.created_at'  
        ]);

        $rules = array(
            'nama_user' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            // 'password' => 'required|string|min:6|confirmed',
            'nomor_telp' => 'required|string|unique:users',
            // 'role' => 'required|max:1',
            // 'status' => 'required|max:1'
        );

        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $user = User::create([
                'nama_user' => $request->nama_user,
                'password' => bcrypt(12345678),
                'email' => $request->email,
                'nomor_telp' => $request->nomor_telp,
                'role' => "3",
                'status' => "1",

            ]);
            
            if($user->role == 1){
                $user->assignRole('admin');
            }elseif ($user->role == 2) {
                $user->assignRole('guru');
            }else{
                $user->assignRole('siswa');
            }

            $token = $user->createToken('token-name')->plainTextToken;

            // $user = $request->user();
            $siswas = new Siswa;
            $siswas->nama_siswa = $user->nama_user;
            $siswas->guru_id = $guru->id;
            $siswas->nisn  = $request->nisn;
            $siswas->sekolah   = $guruProfile->sekolah;
            $siswas->npsn  = $guruProfile->npsn;
            $siswas->user_id = $user->id;
            $siswas->save();
            // $siswas = Siswa::create([
            //     '
            // ]);

            $roles = $user->getRoleNames();
            
            return response()->json([
                'message'   => 'Success',
                'roles'        => $roles[0],
                'token'      => $token,
                // 'identitas' => $identitas,
                'user'      => $user,
                'guru'      => $guruProfile,
                'siswa'      => $siswas,
            ], 200);
        }
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
    // public function store(Request $request)
    // {
    //     $user = $request->user();
    //     {
    //         $rules = array(
    //             'npsn' => 'required|string|max:16',
    //             'nama_guru' => 'required|string|max:20',
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
    //                 $guru = Guru::create([
    //                     'user_id' => $user->id,
    //                     'npsn' => $request->npsn,
    //                     'nama_guru' => $request->nama_guru,
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

    public function npsn(Request $request)
    {
        $user = $request->user();
        $guru = Guru::where('user_id', $user->id)->first();
        $guru->npsn = $request->npsn;
        $guru->sekolah = $request->sekolah;
        
        if($guru->save()){
            return response()->json([
                "status" => "success",
                "message" => 'Berhasil Menyimpan Data',
                'data'  => $guru,
            ]);
        }else{
            return response()->json([
                "status" => "failed",
                "message" => 'Gagal Menyimpan Data'
            ]);
        }
    }
     
    public function update(Request $request, $id)
    {
        
        $file   = $request->file('foto');
        // return $request;
        if($file == ""){   
            $user = $request->user();
            $guru = Guru::where('user_id', $user->id)->first();
            // $guru->user_id = $user->id;
            $guru->npsn = $request->npsn;
            $guru->nama_guru = $request->nama_guru;
            $guru->tempat_lahir = $request->tempat_lahir;
            $guru->tanggal_lahir = $request->tanggal_lahir;
            $guru->alamat = $request->alamat;
            $guru->sekolah = $request->sekolah;
            
            if($guru->save()){
                return response()->json([
                    "status" => "success",
                    "message" => 'Berhasil Menyimpan Data',
                    "foto"  => "tidak"
                ]);
            }else{
                return response()->json([
                    "status" => "failed",
                    "message" => 'Gagal Menyimpan Data'
                ]);
            }
        }else{
            
            $file   = $request->file('foto');
            $user = $request->user();
            $image = Guru::where('user_id', $user->id)->value("foto");
            $result = CloudinaryStorage::replace($image, $file->getRealPath(), $file->getClientOriginalName());
            $user = $request->user();

            $guru = Guru::where('user_id', $user->id)->first();
            // $guru->user_id = $user->id;
            $guru->npsn = $request->npsn;
            $guru->nama_guru = $request->nama_guru;
            $guru->tempat_lahir = $request->tempat_lahir;
            $guru->tanggal_lahir = $request->tanggal_lahir;
            $guru->alamat = $request->alamat;
            $guru->sekolah = $request->sekolah;
            $guru->foto = $result;
            
            if($guru->save()){
                return response()->json([
                    "status" => "success",
                    "message" => 'Berhasil Menyimpan Data',
                    "foto"  => "iya"
                ]);
            }else{
                return response()->json([
                    "status" => "failed",
                    "message" => 'Gagal Menyimpan Data'
                ]);
            }
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
        try {
            $id = explode(",", $id);
            Guru::whereIn('id', $id)->delete();
            return response()->json(["status" => "Success","message" => "Berhasil Menghapus Data"]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
