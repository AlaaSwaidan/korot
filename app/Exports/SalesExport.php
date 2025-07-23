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

class SalesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    function __construct($data) {
        $this->from_date = $data->from_date;
        $this->type = $data->type;
        $this->to_date = $data->to_date;
        $this->time = $data->time;
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
        if ($this->type == "merchants"){
            $user = Merchant::find($this->user_id);
        }elseif ($this->type == "distributors"){
            $user = Distributor::find($this->user_id);
        }
        $data =$user->orders()->where('status',1)->orderBy('id','desc');
        $time = $this->time;
        if ($time == "today") {
            $data = $data->whereDate('created_at', Carbon::now());
        }
        if ($time == "exact_time"){
            $startDate = Carbon::parse($this->from_date);
            $endDate = Carbon::parse($this->to_date);

            $data = $data->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate]);
        }
        $data =$data->get();
        return $data;
    }
    public function headings(): array
    {
        return [
            ['اسم البطاقة','رقم البطاقة','الرقم التسلسلي','سعر البيع','سعر التاجر','تاريخ الانتهاء','التاريخ']
        ];
    }

    public function map($process): array
    {

        return [
            [
                $process->name[app()->getLocale()],
                $process->card_number,
                $process->serial_number,
                $process->card_price,
                $process->merchant_price,
                $process->end_date,
                $process->created_at->format('Y-m-d g:i A'),


            ]

        ];
    }

}
