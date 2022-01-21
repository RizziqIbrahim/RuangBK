<?php

namespace App\Http\Controllers;

use App\Http\Controller\{
    AuthController,
};
use App\Models\{
    Siswa,
    User,
    Guru

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
        $request->keywords;
        $request->page;
        $guru = Guru::leftjoin('users', 'users.id', '=', 'user_id')->where('users.nama_user', 'like', '%'.strtolower($request->keywords)."%")
        ->orderBy("gurus.created_at", 'desc')
        ->paginate($request->perpage, [
            'gurus.id',
            'gurus.user_id',
            'users.status',
            'gurus.nama_guru',
            'gurus.tempat_lahir',
            'gurus.tanggal_lahir',
            'gurus.foto',
            'gurus.alamat',
            'gurus.created_at' 
        ]);

        return response()->json([
            'status' => 'success',
            'perpage' => $request->perpage,
            'message' => 'sukses menampilkan data',
            'data' => $guru,
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
        $user = $request->user();
        {
            $rules = array(
                'nama_guru' => 'required|string|max:20',
                'tempat_lahir' => 'required|string|max:255',
                'tanggal_lahir' => 'required|date',
                'alamat' => 'required|string|max:255',
                'foto' => 'required',
            );
    
            $cek = Validator::make($request->all(),$rules);
    
            if($cek->fails()){
                $errorString = implode(",",$cek->messages()->all());
                return response()->json([
                    'message' => $errorString
                ], 401);
            }else{
                    $guru = Guru::create([
                        'user_id' => $user->id,
                        'nama_guru' => $request->nama_guru,
                        'tempat_lahir' => $request->tempat_lahir,
                        'tanggal_lahir' => $request->tanggal_lahir,
                        'alamat' => $request->alamat,
                        'foto' => $request->foto,
                    ]);
        
                return response()->json([
                    "status" => "success",
                    "message" => 'Berhasil Menyimpan Data',
                ]);
            }
    
        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
