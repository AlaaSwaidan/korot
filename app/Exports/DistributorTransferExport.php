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

class DistributorTransferExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    function __construct($data) {
        $this->user_id = $data->user_id;
        $this->merchant_name = $data->merchant_name;
        $this->transfer_type = $data->transfer_type;

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
        $data =Transfer::orderBy('id','desc')->where('type', $this->transfer_type)->where('providerable_type','App\Models\Distributor')
            ->where('providerable_id',$this->user_id)->where('confirm',1);
        $merchant_name = $this->merchant_name;
        if($merchant_name){
            $data = $data->whereHas('merchant',function ($q) use($merchant_name){
                $q->where('name', 'LIKE', "%$merchant_name%");
                $q->orWhere('name', 'LIKE', "%$merchant_name%");
            });
        }

        $data =$data->get();
        return $data;
    }
    public function headings(): array
    {
        return [
            ['من طرف','التاجر','الرصيد','نوع التحويل','الوصل ','التاريخ']
        ];
    }

    public function map($process): array
    {

        return [
            [
                $process->fromAdmin->name."(".$process->fromAdmin->email.")",
                $process->merchant->name ."(".$process->merchant->email.")",
                $process->amount,
                $process->transfer_type == "fawry" ? "فوري" : "آجل",
                $this->transfer_type == "transfer" ? route('admin.transfers.balance-distributors-pdf', $process->id) :  route('admin.collections.balance-distributors-pdf', $process->id),
                $process->created_at->format('Y-m-d g:i A')


            ]

        ];
    }

}
