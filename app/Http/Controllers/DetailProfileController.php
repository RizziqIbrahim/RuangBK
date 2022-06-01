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
        $detailprofile = DetailProfile::
        where('detailprofile.id', $id)
        ->orderBy("detailprofile.id", 'desc')
        ->paginate($request->perpage, [
            'user_id',
        'detailprofile.nama',
        'detailprofile.jenis_kelamin',
        'detailprofile.NISN',
        'detailprofile.tempat_lahir',
        'detailprofile.tanggal_lahir',
        'detailprofile.NIK',
        'detailprofile.agama',
        'detailprofile.RT',
        'detailprofile.RW',
        'detailprofile.dusun',
        'detailprofile.kelurahan',
        'detailprofile.kecamatan',
        'detailprofile.kode_pos',
        'detailprofile.jenis_tinggal',
        'detailprofile.alat_transportasi',
        'detailprofile.telepon',
        'detailprofile.nomer_hp',
        'detailprofile.email',
        'detailprofile.SKHUN',
        'detailprofile.penerima_KPS',
        'detailprofile.no_KPS',
        'detailprofile.nama_ayah',
        'detailprofile.tahun_lahir_ayah',
        'detailprofile.jenjang_pendidikan_ayah',
        'detailprofile.pekerjaan_ayah',
        'detailprofile.penghasilan_ayah',
        'detailprofile.NIK_ayah',
        'detailprofile.nama_ibu',
        'detailprofile.tahun_lahir_ibu',
        'detailprofile.jenjang_pendidikan_ibu',
        'detailprofile.pekerjaan_ibu',
        'detailprofile.penghasilan_ibu',
        'detailprofile.NIK_ibu',
        'detailprofile.nama_wali',
        'detailprofile.tahun_lahir_wali',
        'detailprofile.jenjang_pendidikan_wali',
        'detailprofile.pekerjaan_wali',
        'detailprofile.penghasilan_wali',
        'detailprofile.NIK_wali',
        'detailprofile.rombel_saat_ini',
        'detailprofile.nomer_peserta_ujian_nasional',
        'detailprofile.nomer_seri_ijazah',
        'detailprofile.penerima_KIP',
        'detailprofile.nomer_KIP',
        'detailprofile.nama_di_KIP',
        'detailprofile.nomer_KKS',
        'detailprofile.nomer_registrasi_akta_lahir',
        'detailprofile.bank',
        'detailprofile.nomer_rekening_bank',
        'detailprofile.rekening_atas_nama',
        'detailprofile.layak_PIP',
        'detailprofile.alasan_layak_PIP',
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
