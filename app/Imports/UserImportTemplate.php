<?php

namespace App\Imports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserImportTemplate implements FromQuery, WithHeadings
{
    use Exportable;

    private static $header = [
        'Nama Panjang',
        'Email',
        'Password',
    ];

    public function query()
    {
        return new Collection();
    }

    public function headings(): array
    {
        return self::$header;
    }

    public static function getHeader(): array
    {
        return self::$header;
    }
}
