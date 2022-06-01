<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Ramsey\Uuid\v1;

class CreateProfileSiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile', function (Blueprint $table) {      
            $table->id();
            $table->string('nama');
            $table->string('jenis_kelamin');
            $table->string('NISN');
            $table->string('tempat_lahir');
            $table->string('tanggal_lahir');
            $table->string('NIK');
            $table->string('agama');
            $table->string('RT');
            $table->string('RW');
            $table->string('dusun');
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->string('kode_pos');
            $table->string('jenis_tinggal');
            $table->string('alat_transportasi');
            $table->string('telepon');
            $table->string('nomer_hp');
            $table->string('email');
            $table->string('SKHUN');
            $table->string('penerima_KPS');
            $table->string('no_KPS');
            $table->string('nama_ayah');
            $table->string('tahun_lahir_ayah');
            $table->string('jenjang_pendidikan_ayah');
            $table->string('pekerjaan_ayah');
            $table->string('penghasilan_ayah');
            $table->string('NIK_ayah');
            $table->string('nama_ibu');
            $table->string('tahun_lahir_ibu');
            $table->string('jenjang_pendidikan_ibu');
            $table->string('pekerjaan_ibu');
            $table->string('penghasilan_ibu');
            $table->string('NIK_ibu');
            $table->string('nama_wali');
            $table->string('tahun_lahir_wali');
            $table->string('jenjang_pendidikan_wali');
            $table->string('pekerjaan_wali');
            $table->string('penghasilan_wali');
            $table->string('NIK_wali');
            $table->string('rombel_saat_ini');
            $table->string('nomer_peserta_ujian_nasional');
            $table->string('nomer_seri_ijazah');
            $table->string('penerima_KIP');
            $table->string('nomer_KIP');
            $table->string('nama_di_KIP');
            $table->string('nomer_KKS');
            $table->string('nomer_registrasi_akta_lahir');
            $table->string('bank');
            $table->string('nomer_rekening_bank');
            $table->string('rekening_atas_nama');
            $table->string('layak_PIP');
            $table->string('alasan_layak_PIP');
            $table->foreignId('created_by');
            $table->foreignId('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
