<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = new User([
            'nama_user' => $row[0],
            'email' => $row[1],
            'password' => bcrypt($row[2]),
            'role' => $row[3],
            'status' => $row[4]
        ]);

        if($row[3] == 1){
            $user->assignRole('admin');
        }elseif ($row[3] == 2) {
            $user->assignRole('guru');
        }elseif ($row[3] == 3) {
            $user->assignRole('siswa');
        }

        return $user;
    }
}
