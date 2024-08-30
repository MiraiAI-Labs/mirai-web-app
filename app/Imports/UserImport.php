<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToModel, WithHeadingRow
{
    use Importable;

    public function uniqueBy()
    {
        return 'email';
    }
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        if (User::where('email', $row['email'])->exists()) {
            return;
        }

        $user = new User([
            'name'     => $row['nama_panjang'],
            'email'    => $row['email'],
            'password' => bcrypt($row['password'] ?? 'password'),
        ]);
        $user->assignRole('user');

        return $user;
    }

    public function headingRow(): int
    {
        return 1;
    }
}
