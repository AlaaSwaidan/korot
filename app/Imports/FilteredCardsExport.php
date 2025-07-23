<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\FromArray;

class FilteredCardsExport implements FromArray
{
    protected $validRows;

    public function __construct($validRows)
    {
        $this->validRows = $validRows;
    }

    public function array(): array
    {
        return $this->validRows;
    }
}

