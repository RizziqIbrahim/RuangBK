<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

Use App\Models\Siswa;
Use App\Models\Guru;
use Permission;
use Role;
use Hash;
use Auth;
use Validator;

class UsersImport implements ToModel
{
    use HasRoles, HasApiTokens;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $request = request()->user()->id;
    
        $user = User::create([
            'nama_user' => $row[0],
            'email' => $row[1],
            'password' => Hash::make($row[2]),
            'nomor_telp' => $row[3],
            'role' => 3,
            'status' => 1,
        ]);

            $siswas = new Siswa;
            $siswas->nama_siswa = $user->nama_user;
            $siswas->guru_id = $request;
            $siswas->nisn  = $row[4];
            $siswas->sekolah  = $row[5];
            $siswas->npsn  = $row[6];
            $siswas->kelas  = $row[7];
            $siswas->user_id = $user->id;
            $siswas->save();

        $user->assignRole('siswa');
        $user->createToken('token-name')->plainTextToken;
        $token = $user->createToken('token-name')->plainTextToken;
        $roles = $user->getRoleNames();
        // if($row[3] == 1){
        //     $user->assignRole('admin');
        // }elseif ($row[3] == 2) {
        //     $user->assignRole('guru');
        // }elseif ($row[3] == 3) {
        //     $user->assignRole('siswa');
        // }
        
        return $user;
    }
}
