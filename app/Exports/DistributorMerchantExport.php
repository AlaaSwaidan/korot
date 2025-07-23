<?php

namespace App\Exports;

use App\Models\Card;
use App\Models\Distributor;
use App\Models\Merchant;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Modules\Transfers\Entities\Transfer;

class DistributorMerchantExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    function __construct($data) {
        $this->user_id = $data->user_id;

    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->setRightToLeft(true)->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }
    public function collection()
    {
        $distributor = Distributor::find($this->user_id);
        $data = $distributor->merchants()->get();
        return $data;
    }
    public function headings(): array
    {
        return [
            ['رقم التاجر','اسم التاجر','رقم الماكينة','تمت الاضافة','البريد الالكتروني ','رقم الجوال','التاريخ']
        ];
    }

    public function map($process): array
    {

        return [
            [
                $process->id,
                $process->name,
                $process->machine_number,
                $process->distributor_id ? $process->distributor->name :  added_by_type($process->added_by_type,$process),
                $process->email,
                $process->phone,
                $process->created_at->format('Y-m-d g:i A')


            ]

        ];
    }

}
