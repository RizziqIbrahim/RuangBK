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
    
        $user = User::create([
            'nama_user' => $row[0],
            'email' => $row[1],
            'password' => ($row[2]),
            'nomor_telp' => $row[3],
            'role' => 3,
            'status' => 1,
        ]);
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
