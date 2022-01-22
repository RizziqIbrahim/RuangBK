<?php

namespace App\Http\Controllers;

use App\Http\Controllers\{
    AuthController,
    CloudinaryStorage,
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
                $image  = $request->file('foto');
                $result = CloudinaryStorage::upload($image->getRealPath(), $image->getClientOriginalName());
                    $guru = Guru::create([
                        'user_id' => $user->id,
                        'nama_guru' => $request->nama_guru,
                        'tempat_lahir' => $request->tempat_lahir,
                        'tanggal_lahir' => $request->tanggal_lahir,
                        'alamat' => $request->alamat,
                        'foto' => $result,
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

        // $file   = $request->file('image');
        // $result = CloudinaryStorage::replace($image->image, $file->getRealPath(), $file->getClientOriginalName());

        $user = $request->user();
        $guru = Guru::where('user_id', $id)->first();
        // $guru->user_id = $user->id;
        $guru->nama_guru = $request->nama_guru;
        $guru->tempat_lahir = $request->tempat_lahir;
        $guru->tanggal_lahir = $request->tanggal_lahir;
        $guru->alamat = $request->alamat;
        $guru->foto = $request->foto;
        if($guru->save()){
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
