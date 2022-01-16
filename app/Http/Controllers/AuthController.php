<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Hash;

class AuthController extends Controller
{
    
    
    public function register(Request $request)
    {
        $rules = array(
            'nama_user' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'nomor_telp' => 'required|string',
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
                'token'      => $token
            ], 200);
        }
    }

    public function login(Request $request)
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
          
            
          
            return response()->json([
                'message'   => 'Success',
                'user'      => $user,
                'token'      => $token,
                'roles' => $roles
            ], 200);
        }
    }

    

    
}
