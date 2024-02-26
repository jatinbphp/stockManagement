<?php

namespace App\Exports;

use App\Models\StockOrder;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrderExport implements FromCollection
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
    public function headings(): array
    {
        return ["Ref#", "Date Ordered", "Supplier", "Brand", "Practice", "Comments", "Date Received", "Invoice Number",
         "GRV Number", 'Additional Notes'];
    }
}
