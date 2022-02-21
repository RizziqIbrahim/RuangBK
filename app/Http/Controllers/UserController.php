<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Exports\UsersExport;
use App\Http\Controller\{
    SiswaController,
    AuthController,
    GuruController,
    AdminController
};
use App\Models\{
    Siswa,
    User,
    Guru,
    Admin
};

use Hash;
use Auth;
use Validator;


class UserController extends Controller
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
        $request->perpage;
        $users = User::where('nama_user', 'like', '%'.strtolower($request->keywords)."%")
        ->orWhere('role', 'like', '%'.strtolower($request->role)."%")
        ->orderBy("created_at", 'desc')
        ->paginate($request->perpage, [
            'users.id',
            'users.nama_user',
            'users.email',
            'users.password',
            'users.nomor_telp',
            'users.role',
            'users.status',
            'users.created_at'
        ]);

        return response()->json([
            'status' => 'success',
            'perpage' => $request->perpage,
            'role' => $request->role,
            'message' => 'sukses menampilkan data',
            'data' => $users 
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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $roles = User::where('id', $id)->value("role"); 

        if ($roles == 2) {
            $data = Guru::where('user_id', $id)->leftjoin('users', 'users.id', '=', 'user_id')->first([
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
            return response()->json([
                'status' => 'success',
                'message' => 'sukses menampilkan data',
                'data' => $data
                
            ]);
        }elseif ($roles == 3) {
            $data = Siswa::where('user_id', $id)->leftjoin('users', 'users.id', '=', 'user_id')->first([
                'siswas.id',
                'siswas.user_id',
                'users.status',
                'users.role',
                'siswas.nisn',
                'siswas.nama_siswa',
                'users.email',
                'siswas.tempat_lahir',
                'siswas.tanggal_lahir',
                'users.nomor_telp',
                'siswas.foto',
                'siswas.alamat',
                'siswas.sekolah',
                'siswas.npsn',
                'siswas.created_at' 
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'sukses menampilkan data',
                'data' => $data
                
            ]);
        }elseif ($roles == 1) {
            $data = Admin::where('user_id', $id)->leftjoin('users', 'users.id', '=', 'user_id')->first([
                'admins.id',
                'admins.user_id',
                'users.status',
                'users.role',
                'admins.npsn',
                'admins.nama_admin',
                'users.email',
                'admins.tempat_lahir',
                'admins.tanggal_lahir',
                'users.nomor_telp',
                'admins.foto',
                'admins.alamat',
                'admins.sekolah',
                'admins.created_at' 
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'sukses menampilkan data',
                'data' => $data
                
            ]);
        }
            
           return response()->json([
                'status' => 'success',
                'message' => 'sukses menampilkan data',
                'data' => $data
                
            ]);
    }

    public function showLogin(Request $request)
    {
        $user = $request->user();
        $roles = User::where('id', $user->id)->value("role"); 

        if ($roles == 2) {
            $data = Guru::where('user_id', $user->id)->leftjoin('users', 'users.id', '=', 'user_id')->first([
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
            return response()->json([
                'status' => 'success',
                'message' => 'sukses menampilkan data',
                'data' => $data
                
            ]);
        }elseif ($roles == 3) {
            $data = Siswa::where('user_id', $user->id)->leftjoin('users', 'users.id', '=', 'user_id')->first([
                'siswas.id',
                'siswas.user_id',
                'users.status',
                'users.role',
                'siswas.nisn',
                'siswas.nama_siswa',
                'users.email',
                'siswas.tempat_lahir',
                'siswas.tanggal_lahir',
                'users.nomor_telp',
                'siswas.foto',
                'siswas.alamat',
                'siswas.sekolah',
                'siswas.kelas',
                'siswas.npsn',
                'siswas.created_at' 
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'sukses menampilkan data',
                'data' => $data
                
            ]);
        }elseif ($roles == 1) {
            $data = Admin::where('user_id', $user->id)->leftjoin('users', 'users.id', '=', 'user_id')->first([
                'admins.id',
                'admins.user_id',
                'users.status',
                'users.role',
                'admins.npsn',
                'admins.nama_admin',
                'users.email',
                'admins.tempat_lahir',
                'admins.tanggal_lahir',
                'users.nomor_telp',
                'admins.foto',
                'admins.alamat',
                'admins.sekolah',
                'admins.created_at' 
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'sukses menampilkan data',
                'data' => $data
                
            ]);
        }
            
           return response()->json([
                'status' => 'success',
                'message' => 'sukses menampilkan data',
                'data' => $data
                
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
        $users = User::where('id', $user->id)->first();
        $users->nama_user = $request->nama_user;
        $users->password = $request->password;
        $users->email = $request->email;
        $users->nomor_telp = $request->nomor_telp;
        $users->role = $user->role;
        $users->status = $user->status;
        
        if($users->save()){
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

    // public function statusActive($id)
    // {
    //     try {
    //         $id = explode(",", $id);
    //         User::whereIn('id', $id)->delete();
    //         return response()->json(["status" => "Success","message" => "Berhasil Menghapus Data"]);
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //     }
    // }

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
            $siswa = Siswa::where('user_id', $id);
            $guru = Guru::where('user_id', $id);
            $admin = Admin::where('user_id', $id);
            $user = User::whereIn('id', $id);
            if ($user->value('role') == 1) {
               $admin->delete(); 
               $user->delete(); 
            }elseif ($user->value('role') == 2) {
                $guru->delete();
                $user->delete();  
            }else{
                $siswa->delete(); 
                $user->delete(); 
            }

            return response()->json(["status" => "Success","message" => "Berhasil Menghapus Data"]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function hapus(Request $request)
    {
       
        try {
           for($i = 0 ; $i < count($request->id) ; $i++){
            $delete = User::find($request->id[$i]);
            $delete->delete();
           }
           return response()->json([
            "status" => "success",
            "message" => 'Berhasil Menyimpan Status'
        ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "status" => "faild",
                "message" => 'id tidak ditemukan | ' . $th
            ]);
        }
        
    }
    public function export()
    {
        return Excel::download(new UsersExport, 'user-export-' . date("Y-m-d") . '.xlsx');
    }

    public function import(Request $request)
    {
        $data = Excel::import(new UsersImport, $request->file('user')->store('temp'));

        if($data){
            return response()->json([
                'message'   => 'Success',
            ], 200);
        }else{
            return response()->json([
                'message'   => 'Gagal',
            ], 200);
        }
    }
}
