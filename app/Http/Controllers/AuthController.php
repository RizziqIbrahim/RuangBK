<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controller\{
    SiswaController,
    AdminContoller,
    GuruController
};
use App\Models\{
    Siswa,
    User,
    Admin,
    Guru
};

use Hash;
use Auth;
use Validator;


class AuthController extends Controller
{
    
    public function register(Request $request)
    {
        $rules = array(
            'nama_user' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
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
                'password' => bcrypt($request->password),
                'email' => $request->email,
                'nomor_telp' => $request->nomor_telp,
                'role' => $request->role,
                'status' => 1

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
            $gurus = Guru::create([
                'nama_guru' => $user->nama_user,
                'user_id' => $user->id,
            ]);

            $roles = $user->getRoleNames();

            if($roles[0] == "admin"){
                $admin = Admin::where('user_id' , '=', $user->id)->first();

                if($admin->npsn == ""){
                    $npsn = "belum terisi";
                }else{
                    $npsn ="terisi";

                }

            }elseif($roles[0] == "guru"){
                $guru = Guru::where('user_id' , '=', $user->id)->first();

                if($guru->npsn == ""){
                    $npsn = "belum terisi";
                }else{
                    $npsn ="terisi";

                }

            }

            if($roles[0] == "admin"){
                $admin = Admin::where('user_id' , '=', $user->id)->first();

                if($admin->alamat == ""){
                    $identitas = "belum terisi";
                }else{
                    $identitas ="terisi";

                }

            }elseif($roles[0] == "guru"){
                $guru = Guru::where('user_id' , '=', $user->id)->first();

                if($guru->alamat == ""){
                    $identitas = "belum terisi";
                }else{
                    $identitas ="terisi";

                }

            }else{
                $siswa = Siswa::where('user_id' , '=', $user->id)->first();

                if($siswa->alamat == ""){
                    $identitas = "belum terisi";
                }else{
                    $identitas ="terisi";

                }

            }

            return response()->json([
                'message'   => 'Success',
                'roles'        => $roles[0],
                'token'      => $token,
                'user'      => $user,
                'guru'      => $gurus,
                'identitas' => $identitas,
                'npsn'  => $npsn,
            ], 200);
        }
    }


    public function loginEmail(Request $request)
    {
        $rules = array(
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        );

        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $user = User::where('email',$request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Unaouthorized'
                ], 401);
            }
            
            if($user->status == 0){
                return response()->json([
                    'message' => 'User Tidak Aktif'
                ], 401);
            }

            
            $token = $user->createToken('token-name')->plainTextToken;
            $roles = $user->getRoleNames();
            

            if($roles[0] == "admin"){
                $admin = Admin::where('user_id' , '=', $user->id)->first();

                if($admin->npsn == ""){
                    $npsn = "belum terisi";
                }else{
                    $npsn ="terisi";

                }

            }elseif($roles[0] == "guru"){
                $guru = Guru::where('user_id' , '=', $user->id)->first();

                if($guru->npsn == ""){
                    $npsn = "belum terisi";
                }else{
                    $npsn ="terisi";

                }

            }else{
                $siswa = Siswa::where('user_id' , '=', $user->id)->first();

                if($siswa->npsn == ""){
                    $npsn = "belum terisi";
                }else{
                    $npsn ="terisi";

                }

            }


            if($roles[0] == "admin"){
                $admin = Admin::where('user_id' , '=', $user->id)->first();
        
                if($admin->alamat == ""){
                    $identitas = "belum terisi";
                }else{
                    $identitas ="terisi";
                  
                }
              
            }elseif($roles[0] == "guru"){
                $guru = Guru::where('user_id' , '=', $user->id)->first();
        
                if($guru->alamat == ""){
                    $identitas = "belum terisi";
                }else{
                    $identitas ="terisi";
                  
                }
              
            }else{
                $siswa = Siswa::where('user_id' , '=', $user->id)->first();
        
                if($siswa->alamat == ""){
                    $identitas = "belum terisi";
                }else{
                    $identitas ="terisi";
                  
                }
              
            }
          
            return response()->json([
                'message'   => 'Success',
                'user'      => $user,
                'token'      => $token,
                'roles' => $roles,
                'identitas' => $identitas,
                'npsn' => $npsn
            ], 200);

        }   
    }

    public function loginNomor(Request $request)
    {
        $rules = array(
            'nomor_telp' => 'required',
            'password' => 'required|string|min:6'
        );

        $cek = Validator::make($request->all(),$rules);

        if($cek->fails()){
            $errorString = implode(",",$cek->messages()->all());
            return response()->json([
                'message' => $errorString
            ], 401);
        }else{
            $user = User::where('nomor_telp',$request->nomor_telp)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Unaouthorized'
                ], 401);
            }

            if($user->status == 0){
                return response()->json([
                    'message' => 'User Tidak Aktif'
                ], 401);
            }

            
            $token = $user->createToken('token-name')->plainTextToken;
            $roles = $user->getRoleNames();


            if($roles[0] == "admin"){
                $admin = Admin::where('user_id' , '=', $user->id)->first();

                if($admin->npsn == ""){
                    $npsn = "belum terisi";
                }else{
                    $npsn ="terisi";

                }

            }elseif($roles[0] == "guru"){
                $guru = Guru::where('user_id' , '=', $user->id)->first();

                if($guru->npsn == ""){
                    $npsn = "belum terisi";
                }else{
                    $npsn ="terisi";

                }

            }

            if($roles[0] == "admin"){
                $admin = Admin::where('user_id' , '=', $user->id)->first();
        
                if($admin->alamat == ""){
                    $identitas = "belum terisi";
                }else{
                    $identitas ="terisi";
                  
                }
              
            }elseif($roles[0] == "guru"){
                $guru = Guru::where('user_id' , '=', $user->id)->first();
        
                if($guru->alamat == ""){
                    $identitas = "belum terisi";
                }else{
                    $identitas ="terisi";
                  
                }
              
            }else{
                $siswa = Siswa::where('user_id' , '=', $user->id)->first();
        
                if($siswa->alamat == ""){
                    $identitas = "belum terisi";
                }else{
                    $identitas ="terisi";
                  
                }
              
            }
          
            return response()->json([
                'message'   => 'Success',
                'user'      => $user,
                'token'      => $token,
                'roles' => $roles,
                'identitas' => $identitas,
                'npsn'  => $npsn
            ], 200);
        }

        
    }

    // public function authMe(Request $request)
    // {
    //     $request->user()->currentAccessToken()->delete();
    //     $token= $request->user()->createToken('token-name')->plainTextToken;
    //     $user = $request->user();
    //     $roles = $user->getRoleNames();
          
    //         if($roles == 1 | 2){
    //             $guru = Guru::where('user_id' , '=', $user->id)->first();
        
    //             if($guru == ""){
    //                 $identitas = "belum terisi";
    //             }else{
    //                 $identitas ="terisi";
                  
    //             }
              
    //         }
    //         if($roles == 3 ){
    //             $siswa = Siswa::where('user_id' , '=', $user->id)->first();
        
    //             if($siswa == ""){
    //                 $identitas = "belum terisi";
    //             }else{
    //                 $identitas ="terisi";
                  
    //             }
              
    //         }
       
    //     return response()->json([
    //         'message'   => 'Success',
    //         'user'      => $user,
    //         'token'      => $token,
    //         'identitas' => $identitas
    //     ], 200);
    // }

    

    

    
}
