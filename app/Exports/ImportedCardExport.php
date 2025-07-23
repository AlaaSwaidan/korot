<?php
namespace App\Exports;

use App\Models\Card;
use App\Models\Package;
use App\Models\Store;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class ImportedCardExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    private $totals = [
        'total_cards' => 0,
        'total_cost' => 0,
    ];

    function __construct($data) {
        $this->category_id = $data->category_id;
        $this->package_id = $data->package_id;
        $this->company_id = $data->company_id;
        $this->from_date = $data->from_date;
        $this->to_date = $data->to_date;
    }


    public function collection()
    {
        $imported = Card::where('imported', 1);

        if ($this->from_date && !$this->to_date) {
            $imported = $imported->whereDate('cards.created_at', $this->from_date);
        } elseif ($this->from_date && $this->to_date) {
            $imported = $imported->whereBetween(DB::raw('DATE(cards.created_at)'), [$this->from_date, $this->to_date]);
        }

        if ($this->package_id) {
            $imported = $imported->where('cards.package_id', $this->package_id);
        }

        if ($this->company_id && !$this->category_id && !$this->package_id) {
            $stores = Store::where('id', $this->company_id)->pluck('id')->toArray();
            $categories = Store::where('parent_id', $stores)->pluck('id')->toArray();
            $packages = Package::whereIn('store_id', $categories)->orderBy('id', 'desc')->pluck('id')->toArray();
            $imported = $imported->whereIn('cards.package_id', $packages);
        }

        if ($this->company_id && $this->category_id && !$this->package_id) {
            $categories = Store::where('id', $this->category_id)->pluck('id')->toArray();
            $packages = Package::whereIn('store_id', $categories)->orderBy('id', 'desc')->pluck('id')->toArray();
            $imported = $imported->whereIn('cards.package_id', $packages);
        }

        $data = $imported
            ->join('packages', 'cards.package_id', '=', 'packages.id')
            ->selectRaw('cards.package_id, COUNT(cards.id) as total_cards, SUM(packages.cost) as total_cost, MAX(cards.id) as max_id')
            ->groupBy('cards.package_id')
            ->orderBy('max_id', 'DESC')->get();

        // Calculate total cards and total cost
        $this->totals['total_cards'] = $data->sum('total_cards');
        $this->totals['total_cost'] = $data->sum('total_cost');

        return $data;
    }

    public function headings(): array
    {
        return [
            ['الفئة', 'العدد', 'مجموع التكلفة'],
        ];
    }

    public function map($card): array
    {
        return [
            $card->full_name,
            $card->total_cards,
            number_format($card->total_cost, 2),
        ];
    }

    // Append totals as the last row in the export
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->setRightToLeft(true)->getStyle($cellRange)->getFont()->setSize(14);



                // Get the row number for the totals
                $lastRow = $event->sheet->getHighestRow() + 1;


                // Manually set the totals row
                $event->sheet->getDelegate()->setCellValue('A' . $lastRow, 'المجموع');
                $event->sheet->getDelegate()->setCellValue('B' . $lastRow, $this->totals['total_cards']);
                $event->sheet->getDelegate()->setCellValue('C' . $lastRow, number_format($this->totals['total_cost'], 2));
            },
        ];
    }
}
