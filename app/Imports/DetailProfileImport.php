<?php

namespace App\Imports;

use App\Models\DetailProfile;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class DetailProfileImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    protected $id;
    public function __construct($id) 
    {
        $this->id = $id;
    }
    public function model(array $row)
    {
        return new DetailProfile([
            'user_id' => $this->id,
            'nama' => $row["nama"],
            'nipd' => $row["nipd"],
            'jenis_kelamin' => $row["jk"],
            'nisn' => $row["nisn"],
            'tempat_lahir' => $row["tempat_lahir"],
            'tanggal_lahir' => $row["tanggal_lahir"],
            'nik' => $row["nik"],
            'agama' => $row["agama"],
            'alamat' => $row["alamat"],
            'rt' => $row["rt"],
            'rw' => $row["rw"],
            'dusun' => $row["dusun"],
            'kelurahan' => $row["kelurahan"],
            'kecamatan' => $row["kecamatan"],
            'kode_pos' => $row["kode_pos"],
            'jenis_tinggal' => $row["jenis_tinggal"],
            'alat_transportasi' => $row["alat_transportasi"],
            'telepon' => $row["telepon"],
            'nomer_hp' => $row["hp"],
            'email' => $row["email"],
            'skhun' => $row["skhun"],
            'penerima_kps' => $row["penerima_kps"],
            'no_kps' => $row["no_kps"],
            'nama_ayah' => $row["nama_ayah"],
            'tahun_lahir_ayah' => $row["tahun_lahir_ayah"],
            'jenjang_pendidikan_ayah' => $row["jenjang_pendidikan_ayah"],
            'pekerjaan_ayah' => $row["pekerjaan_ayah"],
            'penghasilan_ayah' => $row["penghasilan_ayah"],
            'nik_ayah' => $row["nik_ayah"],
            'nama_ibu' => $row["nama_ibu"],
            'tahun_lahir_ibu' => $row["tahun_lahir_ibu"],
            'jenjang_pendidikan_ibu' => $row["jenjang_pendidikan_ibu"],
            'pekerjaan_ibu' => $row["pekerjaan_ibu"],
            'penghasilan_ibu' => $row["penghasilan_ibu"],
            'nik_ibu' => $row["nik_ibu"],
            'nama_wali' => $row["nama_wali"],
            'tahun_lahir_wali' => $row["tahun_lahir_wali"],
            'jenjang_pendidikan_wali' => $row["jenjang_pendidikan_wali"],
            'pekerjaan_wali' => $row["pekerjaan_wali"],
            'penghasilan_wali' => $row["penghasilan_wali"],
            'nik_wali' => $row["nik_wali"],
            'rombel_saat_ini' => $row["rombel_saat_ini"],
            'nomer_peserta_ujian_nasional' => $row["no_peserta"],
            'nomer_seri_ijazah' => $row["no_seri_ijazah"],
            'penerima_kip' => $row["penerima_kip"],
            'nomer_kip' => $row["nomor_kip"],
            'nama_di_kip' => $row["nama_di_kip"],
            'nomer_kks' => $row["no_kks"],
            'nomer_registrasi_akta_lahir' => $row["no_registrasi_akta_lahir"],
            'bank' => $row["bank"],
            'nomer_rekening_bank' => $row["nomor_rekening_bank"],
            'rekening_atas_nama' => $row["rekening_atas_nama"],
            'layak_pip' => $row["layak_pip"],
            'alasan_layak_pip' => $row["alasan_layak_pip"],
        ]);

    }

}
