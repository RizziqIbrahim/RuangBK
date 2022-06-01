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
    Angket,
    DetailProfile
};

use Hash;
use Auth;
use Validator;
use App\Exports\JawabanExport;
use Maatwebsite\Excel\Facades\Excel;

class DetailProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $request->keywords;
        $request->page;
        $request->user;
        $detailprofile = DetailProfile::leftjoin('users', 'users.id', '=', 'detail_profile.user_id')
        ->where('detail_profile.id', $id)
        ->orderBy("detail_profile.id", 'desc')
        ->paginate($request->perpage, [
        'detail_profile.user_id',
        'detail_profile.nama',
        'detail_profile.jenis_kelamin',
        'detail_profile.nisn',
        'detail_profile.tempat_lahir',
        'detail_profile.tanggal_lahir',
        'detail_profile.nik',
        'detail_profile.agama',
        'detail_profile.rt',
        'detail_profile.rw',
        'detail_profile.dusun',
        'detail_profile.kelurahan',
        'detail_profile.kecamatan',
        'detail_profile.kode_pos',
        'detail_profile.jenis_tinggal',
        'detail_profile.alat_transportasi',
        'detail_profile.telepon',
        'detail_profile.nomer_hp',
        'detail_profile.email',
        'detail_profile.skhun',
        'detail_profile.penerima_kps',
        'detail_profile.no_kps',
        'detail_profile.nama_ayah',
        'detail_profile.tahun_lahir_ayah',
        'detail_profile.jenjang_pendidikan_ayah',
        'detail_profile.pekerjaan_ayah',
        'detail_profile.penghasilan_ayah',
        'detail_profile.nik_ayah',
        'detail_profile.nama_ibu',
        'detail_profile.tahun_lahir_ibu',
        'detail_profile.jenjang_pendidikan_ibu',
        'detail_profile.pekerjaan_ibu',
        'detail_profile.penghasilan_ibu',
        'detail_profile.nik_ibu',
        'detail_profile.nama_wali',
        'detail_profile.tahun_lahir_wali',
        'detail_profile.jenjang_pendidikan_wali',
        'detail_profile.pekerjaan_wali',
        'detail_profile.penghasilan_wali',
        'detail_profile.nik_wali',
        'detail_profile.rombel_saat_ini',
        'detail_profile.nomer_peserta_ujian_nasional',
        'detail_profile.nomer_seri_ijazah',
        'detail_profile.penerima_kip',
        'detail_profile.nomer_kip',
        'detail_profile.nama_di_kip',
        'detail_profile.nomer_kks',
        'detail_profile.nomer_registrasi_akta_lahir',
        'detail_profile.bank',
        'detail_profile.nomer_rekening_bank',
        'detail_profile.rekening_atas_nama',
        'detail_profile.layak_pip',
        'detail_profile.alasan_layak_pip',
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'sukses menampilkan data',
            'data' => $detailprofile,
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
        //
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
