<?php

namespace App\Http\Controllers;

use App\Http\Controllers\{
    AuthController,
    CloudinaryStorage,
};
use App\Models\{
    Siswa,
    User,
    Admin,
    Guru

};

use Illuminate\Http\Request;
use Hash;
use Auth;
use Validator;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function index(Request $request)
    {
        $user = $request->user();
        $request->keywords;
        $request->page;
        $request->perpage;
        $admin = Admin::leftjoin('users', 'users.id', '=', 'user_id')->where('users.nama_user', 'like', '%'.strtolower($request->keywords)."%")
        ->orderBy("admins.created_at", 'desc')
        ->paginate($request->perpage, [
            'admins.id',
            'admins.user_id',
            'users.status',
            'admins.nama_admin',
            'users.email',
            'users.nomor_telp',
            'admins.tempat_lahir',
            'admins.tanggal_lahir',
            'admins.foto',
            'admins.alamat',
            'admins.sekolah',
            'admins.created_at' 
        ]);

        return response()->json([
            'status' => 'success',
            'perpage' => $request->perpage,
            'message' => 'sukses menampilkan data',
            'data' => $admin,
            'user' => $user->id
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
        // $user = $request->user();
        // {
        //     $rules = array(
        //         'nama_admin' => 'required|string|max:20',
        //         'tempat_lahir' => 'required|string|max:255',
        //         'tanggal_lahir' => 'required|date',
        //         'alamat' => 'required|string|max:255',
        //         'foto' => 'required',
        //     );
    
        //     $cek = Validator::make($request->all(),$rules);
    
        //     if($cek->fails()){
        //         $errorString = implode(",",$cek->messages()->all());
        //         return response()->json([
        //             'message' => $errorString
        //         ], 401);
        //     }else{
        //         $image  = $request->file('foto');
        //         $result = CloudinaryStorage::upload($image->getRealPath(), $image->getClientOriginalName());
        //             $admin = Admin::create([
        //                 'user_id' => $user->id,
        //                 'nama_admin' => $request->nama_admin,
        //                 'tempat_lahir' => $request->tempat_lahir,
        //                 'tanggal_lahir' => $request->tanggal_lahir,
        //                 'alamat' => $request->alamat,
        //                 'foto' => $result,
        //             ]);
        
        //         return response()->json([
        //             "status" => "success",
        //             "message" => 'Berhasil Menyimpan Data',
        //         ]);
        //     }
    
        // }
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

        $file   = $request->file('foto');
        
        $user = $request->user();
        $image = Admin::where('user_id', $user->id)->value("foto");
        $result = CloudinaryStorage::replace($image, $file->getRealPath(), $file->getClientOriginalName());

        $user = $request->user();
        $admin = Admin::where('user_id', $user->id)->first();
        // $admin->user_id = $user->id;
        $admin->npsn = $request->npsn;
        $admin->nama_admin = $request->nama_admin;
        $admin->tempat_lahir = $request->tempat_lahir;
        $admin->tanggal_lahir = $request->tanggal_lahir;
        $admin->alamat = $request->alamat;
        $admin->sekolah = $request->sekolah;
        $admin->foto = $result;
        
        if($admin->save()){
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
        $admin = Admin::where('user_id', $user->id)->first();
        $admin->npsn = $request->npsn;
        $guru->sekolah = $request->sekolah;
        
        if($admin->save()){
            return response()->json([
                "status" => "success",
                "message" => 'Berhasil Menyimpan Data',
                "data"  => $admin,
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
        try {
            $id = explode(",", $id);
            Admin::whereIn('id', $id)->delete();
            return response()->json(["status" => "Success","message" => "Berhasil Menghapus Data"]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
