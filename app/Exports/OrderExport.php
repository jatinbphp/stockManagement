<?php

namespace App\Exports;

use App\Models\StockOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class OrderExport implements FromCollection, WithCustomCsvSettings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function getCsvSettings(): array{
        return [
            'encoding' => 'UTF-8', // Specify the encoding format here
        ];
    }
}
