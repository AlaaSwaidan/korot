<?php

namespace App\Exports;

use App\Models\Card;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class CardExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

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
        return Card::Order()->NotSold()->get();
    }
    public function headings(): array
    {
        return [
            ['رقم البطاقة','الرقم التسلسلي','تاريخ الانتهاء']
        ];
    }

    public function map($card): array
    {

        return [
            [
                $card->card_number ,
                $card->serial_number ,
                $card->end_date
            ]

        ];
    }

}
