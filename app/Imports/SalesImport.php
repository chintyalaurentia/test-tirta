<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToArray;


class SalesImport implements ToArray
{
    public function array(array $array)
    {
        // Process the Excel data in $array
        return $array;
    }
}
