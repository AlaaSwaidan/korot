<?php

namespace App\Exports;

use App\Models\Card;
use App\Models\Order;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class CardTransactionExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    function __construct($data) {
        $this->card_num = $data->card_num;
        $this->transaction_id = $data->transaction_id;

    }
//    public function columnFormats(): array
//    {
//        return [
//            // F is the column
//            'A' => NumberFormat::FORMAT_TEXT,
//            'B' => NumberFormat::FORMAT_TEXT
//        ];
//    }
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
        $card_name = $this->card_num;
        $transaction_id = $this->transaction_id;
        $orders = Order::where('transaction_id',$transaction_id)->pluck('serial_number');
        $data = Card::Order()->Sold();
        if($card_name){
            $data = $data->where(function ($q) use($card_name){
                $q->where('card_number', 'LIKE', "%$card_name%");
                $q->orWhere('serial_number', 'LIKE', "%$card_name%");
            });
        }
        if($transaction_id){
        $data = $data->whereIn('serial_number',$orders);
        }
      $data = $data->get();
        return $data;
    }
    public function headings(): array
    {
        return [
            ['رقم البطاقة','الرقم التسلسلي','تاريخ الانتهاء','التاجر','رقم العملية']
        ];
    }

    public function map($card): array
    {

        return [
            [
                 $card->card_number ,
                (string) $card->serial_number ,
                $card->end_date,
                getOrder($card) ?  getOrder($card)->merchant->name : '--',
                getTransactionId($card->card_number,$card->serial_number),
            ]

        ];
    }

}
