<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailProfile extends Model
{
    protected $table = "detailprofile";
    protected $fillable = [
        'user_id',
        'nama',
        'jenis_kelamin',
        'NISN',
        'tempat_lahir',
        'tanggal_lahir',
        'NIK',
        'agama',
        'RT',
        'RW',
        'dusun',
        'kelurahan',
        'kecamatan',
        'kode_pos',
        'jenis_tinggal',
        'alat_transportasi',
        'telepon',
        'nomer_hp',
        'email',
        'SKHUN',
        'penerima_KPS',
        'no_KPS',
        'nama_ayah',
        'tahun_lahir_ayah',
        'jenjang_pendidikan_ayah',
        'pekerjaan_ayah',
        'penghasilan_ayah',
        'NIK_ayah',
        'nama_ibu',
        'tahun_lahir_ibu',
        'jenjang_pendidikan_ibu',
        'pekerjaan_ibu',
        'penghasilan_ibu',
        'NIK_ibu',
        'nama_wali',
        'tahun_lahir_wali',
        'jenjang_pendidikan_wali',
        'pekerjaan_wali',
        'penghasilan_wali',
        'NIK_wali',
        'rombel_saat_ini',
        'nomer_peserta_ujian_nasional',
        'nomer_seri_ijazah',
        'penerima_KIP',
        'nomer_KIP',
        'nama_di_KIP',
        'nomer_KKS',
        'nomer_registrasi_akta_lahir',
        'bank',
        'nomer_rekening_bank',
        'rekening_atas_nama',
        'layak_PIP',
        'alasan_layak_PIP',
    ];
}
