<?php

namespace App\Exports;

use App\Models\Card;
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

class ProcessExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    function __construct($data) {
        $this->from_date = $data->from_date;
        $this->type = $data->type;
        $this->to_date = $data->to_date;
        $this->user_name = $data->user_name;
        $this->time = $data->time;
        $this->process_type = $data->process_type;
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

        $merchant = Merchant::find($this->user_id);
        $data =$merchant->userable()->where('paid_order','paid')->Order();
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
            ['الاسم','النوع','المبلغ','التحويلات','التحصيلات','المديونية','التعويضات','الرصيد','التاريخ']
        ];
    }

    public function map($process): array
    {
        $merchant = Merchant::find($this->user_id);

        $get_data = $merchant->userable()
            ->where('paid_order','paid')
            ->Order();
        $time = $this->time;
        if (isset($get_data)){
            $transfers = clone $get_data;
            $collections = clone $get_data;
            $repayment = clone $get_data;
            $indebtedness = clone $get_data;
            $indebtedness1 = clone $get_data;
            $profits = clone $get_data;
            $profits1 = clone $get_data;
        }

        if (isset($time) && $time == "today") {
            $transfers = $transfers->where('type','transfer')->whereDate('created_at', \Carbon\Carbon::now())->sum('amount');
            $collections = $collections->where('type','collection')->whereDate('created_at', \Carbon\Carbon::now())->sum('amount');
            $repayment = $repayment->where('type','repayment')->whereDate('created_at', \Carbon\Carbon::now())->sum('amount');
            $indebtedness = $indebtedness->where('type','indebtedness')->whereDate('created_at', \Carbon\Carbon::now())->sum('amount')+
                $indebtedness1->where('type','payment')->whereDate('created_at', \Carbon\Carbon::now())->sum('amount') ;
            $profits = $profits->where('type','profits')->whereDate('created_at', \Carbon\Carbon::now())->sum('amount')+
                $profits1->where('type','sales')->whereDate('created_at', \Carbon\Carbon::now())->sum('profits') ;
        }elseif (isset($time) && $time == "exact_time"){
            $startDate =Carbon::parse($this->from_date);
            $transfers = $transfers->where('type','transfer')->whereBetween('created_at', [$startDate, $process->created_at])->sum('amount');
            $collections = $collections->where('type','collection')->whereBetween('created_at', [$startDate, $process->created_at])->sum('amount');
            $repayment = $repayment->where('type','repayment')->whereBetween('created_at', [$startDate, $process->created_at])->sum('amount');
            $indebtedness = $indebtedness->where('type','indebtedness')->whereBetween('created_at', [$startDate, $process->created_at])->sum('amount')+
                $indebtedness1->where('type','payment')->whereBetween('created_at', [$startDate, $process->created_at])->sum('amount');
            $profits = $profits->where('type','profits')->whereBetween('created_at', [$startDate, $process->created_at])->sum('amount')+
                $profits1->where('type','sales')->whereBetween('created_at', [$startDate, $process->created_at])->sum('profits');
        }else{
            $transfers =$process->type == "transfer"?  ($process->transfers_total ?? 0) : '';
            $collections =$process->type == "collection"?  ($process->collection_total ?? 0) : '';
            $repayment =$process->type == "repayment"?  ($process->repayment_total ?? 0) : '';
            $indebtedness =$process->type == "indebtedness" || $process->type == "payment" ? ($process->indebtedness ?? 0) : '';
            $profits =$process->type == "profits" || $process->type == "sales"  ? $process->profits_total : '';
        }

        return [
            [
                getUserModel(getClassModel($this->type),$process->userable_id)->name  ,
                getProcessType($process->type),
                $process->amount,
                $process->type == "transfer"?  $transfers : '',
                $process->type == "collection" ? $collections : '',
                $process->type == "indebtedness" || $process->type == "payment" ? $indebtedness : '',
                $process->type == "repayment" ?  $repayment : '',
                $process->balance_total,
                $process->created_at->format('Y-m-d'),
            ]

        ];
    }

}
