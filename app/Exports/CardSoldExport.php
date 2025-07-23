<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class CardSoldExport implements FromQuery, WithHeadings, WithMapping
{
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->setRightToLeft(true)->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }

    public function query()
    {
        return Order::whereIn('paid_order', ['cancel', 'not_paid'])
            ->whereHas('card', function ($query) {
                $query->where('sold', 1);
            })
            ->whereDoesntHave('card.orders', function ($query) {
                $query->where('paid_order', 'paid');
            })
            ->whereDate('end_date', '>', '2025-02-06')
            ->select('card_number', 'serial_number', 'end_date', 'created_at');

    }

    public function headings(): array
    {
        return ["Card Number", "Serial Number", "End Date", "Created At"];
    }

    // Formats each row before exporting (Optional)
    public function map($order): array
    {
        return [
            $order->card_number,
            $order->serial_number,
            $order->end_date,
            $order->created_at->format('Y-m-d H:i:s'),
        ];
    }
    public function chunkSize(): int
    {
        return 1000;  // Adjust this to a smaller number if necessary
    }
}
