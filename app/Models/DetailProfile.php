<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailProfile extends Model
{
    protected $table = "detail_profile";
    protected $fillable = [
        'user_id',
        'nama',
        'jenis_kelamin',
        'nipd',
        'nisn',
        'tempat_lahir',
        'tanggal_lahir',
        'nik',
        'agama',
        'alamat',
        'rt',
        'rw',
        'dusun',
        'kelurahan',
        'kecamatan',
        'kode_pos',
        'jenis_tinggal',
        'alat_transportasi',
        'telepon',
        'nomer_hp',
        'email',
        'skhun',
        'penerima_kps',
        'no_kps',
        'nama_ayah',
        'tahun_lahir_ayah',
        'jenjang_pendidikan_ayah',
        'pekerjaan_ayah',
        'penghasilan_ayah',
        'nik_ayah',
        'nama_ibu',
        'tahun_lahir_ibu',
        'jenjang_pendidikan_ibu',
        'pekerjaan_ibu',
        'penghasilan_ibu',
        'nik_ibu',
        'nama_wali',
        'tahun_lahir_wali',
        'jenjang_pendidikan_wali',
        'pekerjaan_wali',
        'penghasilan_wali',
        'nik_wali',
        'rombel_saat_ini',
        'nomer_peserta_ujian_nasional',
        'nomer_seri_ijazah',
        'penerima_kip',
        'nomer_kip',
        'nama_di_kip',
        'nomer_kks',
        'nomer_registrasi_akta_lahir',
        'bank',
        'nomer_rekening_bank',
        'rekening_atas_nama',
        'layak_pip',
        'alasan_layak_pip',
    ];
}
