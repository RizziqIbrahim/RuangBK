<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controller\{
    SiswaController,
};
use App\Models\{
    Siswa,
    User,

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
            'role' => 'required|max:1',
            'status' => 'required|max:1'
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
                'status' => $request->status
            ]);

            
            
            if($request->role == 1){
                $user->assignRole('admin');
            }elseif ($request->role == 2) {
                $user->assignRole('guru');
            }else{
                $user->assignRole('siswa');
            }
            
            $token = $user->createToken('token-name')->plainTextToken;

            return response()->json([
                'message'   => 'Success',
                'token'      => $token,
                'user'      => $user
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


            if($roles == 1){
                $admin = Admin::where('user_id' , '=', $user->id)->first();
        
                if($admin == ""){
                    $identias = "belum terisi";
                }else{
                    $identias ="terisi";
                  
                }
              
            }elseif($roles == 2){
                $guru = Guru::where('user_id' , '=', $user->id)->first();
        
                if($guru == ""){
                    $identias = "belum terisi";
                }else{
                    $identias ="terisi";
                  
                }
              
            }elseif($roles == 3 ){
                $siswa = Siswa::where('user_id' , '=', $user->id)->first();
        
                if($siswa == ""){
                    $identias = "belum terisi";
                }else{
                    $identias ="terisi";
                  
                }
              
            }

            if($user->status == 0){
                return response()->json([
                    'message' => 'User Tidak Aktif'
                ], 401);
            }

            
            $token = $user->createToken('token-name')->plainTextToken;
            $roles = $user->getRoleNames();
          
            return response()->json([
                'message'   => 'Success',
                'user'      => $user,
                'token'      => $token,
                'roles' => $roles,
                'identitas' => $identitas
            ], 200);
        }   
    }

    public function loginNomor(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        $token= $request->user()->createToken('token-name')->plainTextToken;
        $user = $request->user();
        $roles = $user->getRoleNames();

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

            if($roles == 1){
                $admin = Admin::where('user_id' , '=', $user->id)->first();
        
                if($admin == ""){
                    $identias = "belum terisi";
                }else{
                    $identias ="terisi";
                  
                }
              
            }

            if($roles == 2){
                $guru = Guru::where('user_id' , '=', $user->id)->first();
        
                if($guru == ""){
                    $identias = "belum terisi";
                }else{
                    $identias ="terisi";
                  
                }
              
            }
            if($roles == 3 ){
                $siswa = Siswa::where('user_id' , '=', $user->id)->first();
        
                if($siswa == ""){
                    $identias = "belum terisi";
                }else{
                    $identias ="terisi";
                  
                }
              
            }

            if($user->status == 0){
                return response()->json([
                    'message' => 'User Tidak Aktif'
                ], 401);
            }

            
            $token = $user->createToken('token-name')->plainTextToken;
            $roles = $user->getRoleNames();
          
            
          
            return response()->json([
                'message'   => 'Success',
                'user'      => $user,
                'token'      => $token,
                'roles' => $roles,
                'identitas' => $identitas
            ], 200);
        }

        
    }

    public function authMe(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        $token= $request->user()->createToken('token-name')->plainTextToken;
        $user = $request->user();
        $roles = $user->getRoleNames();
          
            if($roles == 1 | 2){
                $guru = Guru::where('user_id' , '=', $user->id)->first();
        
                if($guru == ""){
                    $identias = "belum terisi";
                }else{
                    $identias ="terisi";
                  
                }
              
            }
            if($roles == 3 ){
                $siswa = Siswa::where('user_id' , '=', $user->id)->first();
        
                if($siswa == ""){
                    $identias = "belum terisi";
                }else{
                    $identias ="terisi";
                  
                }
              
            }
       
        return response()->json([
            'message'   => 'Success',
            'user'      => $user,
            'token'      => $token,
            'identias' => $identias
        ], 200);
    }

    

    

    
}
