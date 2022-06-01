<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_profile', function (Blueprint $table) {
            $table->id();
            $table->foreign('user_id');
            $table->string('nama');
            $table->string('jenis_kelamin');
            $table->string('nisn');
            $table->string('tempat_lahir');
            $table->string('tanggal_lahir');
            $table->string('nik');
            $table->string('agama');
            $table->string('rt');
            $table->string('rw');
            $table->string('dusun');
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->string('kode_pos');
            $table->string('jenis_tinggal');
            $table->string('alat_transportasi');
            $table->string('telepon');
            $table->string('nomer_hp');
            $table->string('email');
            $table->string('skhun');
            $table->string('penerima_kps');
            $table->string('no_kps');
            $table->string('nama_ayah');
            $table->string('tahun_lahir_ayah');
            $table->string('jenjang_pendidikan_ayah');
            $table->string('pekerjaan_ayah');
            $table->string('penghasilan_ayah');
            $table->string('nik_ayah');
            $table->string('nama_ibu');
            $table->string('tahun_lahir_ibu');
            $table->string('jenjang_pendidikan_ibu');
            $table->string('pekerjaan_ibu');
            $table->string('penghasilan_ibu');
            $table->string('nik_ibu');
            $table->string('nama_wali');
            $table->string('tahun_lahir_wali');
            $table->string('jenjang_pendidikan_wali');
            $table->string('pekerjaan_wali');
            $table->string('penghasilan_wali');
            $table->string('nik_wali');
            $table->string('rombel_saat_ini');
            $table->string('nomer_peserta_ujian_nasional');
            $table->string('nomer_seri_ijazah');
            $table->string('penerima_kip');
            $table->string('nomer_kip');
            $table->string('nama_di_kip');
            $table->string('nomer_kks');
            $table->string('nomer_registrasi_akta_lahir');
            $table->string('bank');
            $table->string('nomer_rekening_bank');
            $table->string('rekening_atas_nama');
            $table->string('layak_pip');
            $table->string('alasan_layak_pip');
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
        Schema::dropIfExists('detail_profile');
    }
}
