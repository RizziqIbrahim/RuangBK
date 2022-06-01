<?php

namespace App\Imports;

use App\Models\DetailProfile;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;


class DetailProfileImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $profile = Profile::create([
            'user_id' => $row[0],
            'nama' => $row[1],
            'jenis_kelamin' => $row[2],
            'NISN' => $row[3],
            'tempat_lahir' => $row[4],
            'tanggal_lahir' => $row[5],
            'NIK' => $row[6],
            'agama' => $row[7],
            'RT' => $row[8],
            'RW' => $row[9],
            'dusun' => $row[10],
            'kelurahan' => $row[11],
            'kecamatan' => $row[12],
            'kode_pos' => $row[13],
            'jenis_tinggal' => $row[14],
            'alat_transportasi' => $row[15],
            'telepon' => $row[16],
            'nomer_hp' => $row[17],
            'email' => $row[18],
            'SKHUN' => $row[19],
            'penerima_KPS' => $row[20],
            'no_KPS' => $row[21],
            'nama_ayah' => $row[22],
            'tahun_lahir_ayah' => $row[23],
            'jenjang_pendidikan_ayah' => $row[24],
            'pekerjaan_ayah' => $row[25],
            'penghasilan_ayah' => $row[26],
            'NIK_ayah' => $row[27],
            'nama_ibu' => $row[28],
            'tahun_lahir_ibu' => $row[29],
            'jenjang_pendidikan_ibu' => $row[30],
            'pekerjaan_ibu' => $row[31],
            'penghasilan_ibu' => $row[32],
            'NIK_ibu' => $row[33],
            'nama_wali' => $row[34],
            'tahun_lahir_wali' => $row[35],
            'jenjang_pendidikan_wali' => $row[36],
            'pekerjaan_wali' => $row[37],
            'penghasilan_wali' => $row[38],
            'NIK_wali' => $row[39],
            'rombel_saat_ini' => $row[40],
            'nomer_peserta_ujian_nasional' => $row[41],
            'nomer_seri_ijazah' => $row[42],
            'penerima_KIP' => $row[43],
            'nomer_KIP' => $row[44],
            'nama_di_KIP' => $row[45],
            'nomer_KKS' => $row[46],
            'nomer_registrasi_akta_lahir' => $row[47],
            'bank' => $row[48],
            'nomer_rekening_bank' => $row[49],
            'rekening_atas_PIP' => $row[50],
            'layak_PIP' => $row[51],
            'alasan_layak_PIP' => $row[52],
            ]);
            
            return $profile;
    }
}
