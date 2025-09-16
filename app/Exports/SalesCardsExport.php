<?php

namespace App\Exports;

use App\Models\Card;
use App\Models\Distributor;
use App\Models\Merchant;
use App\Models\Package;
use App\Models\Store;
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

class SalesCardsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    function __construct($data) {

        $this->category_id = $data->category_id;
        $this->package_id = $data->package_id;
        $this->company_id = $data->company_id;
        $this->from_date = $data->from_date;
        $this->to_date = $data->to_date;

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
        // Initialize the query for cards
        $cards = Card::query();

        // Handle filtering by date
        if ($this->from_date && $this->to_date == null) {
            $cards = $cards->whereDate('cards.updated_at', $this->from_date);
        }

        if ($this->from_date && $this->to_date) {
            $cards = $cards->whereBetween(DB::raw('DATE(cards.updated_at)'), [$this->from_date, $this->to_date]);
        }

        // Filter by package_id
        if ($this->package_id) {
            $cards = $cards->where('cards.package_id', $this->package_id);
        }

        // Handle filtering by company and category if necessary
        if ($this->company_id && $this->category_id == null && $this->package_id == null) {
            $stores = Store::where('id', $this->company_id)->pluck('id')->toArray();
            $categories = Store::where('parent_id', $stores)->pluck('id')->toArray();
            $packages = Package::whereIn('store_id', $categories)->orderBy('id', 'desc')->pluck('id')->toArray();
            $cards = $cards->whereIn('cards.package_id', $packages);
        }

        if ($this->company_id && $this->category_id && $this->package_id == null) {
            $categories = Store::where('id', $this->category_id)->pluck('id')->toArray();
            $packages = Package::whereIn('store_id', $categories)->orderBy('id', 'desc')->pluck('id')->toArray();
            $cards = $cards->whereIn('cards.package_id', $packages);
        }

        // Query for the sales data
        $data = $cards
            ->join('packages', 'cards.package_id', '=', 'packages.id')
            ->selectRaw("
            cards.package_id,
            COUNT(cards.id) as total_cards,

            -- Sold cards per day
            COUNT(CASE WHEN sold = 1 AND DATE(cards.updated_at) = CURDATE() THEN 1 ELSE NULL END) as sold_per_day,

            -- Sold cards per week
            COUNT(CASE WHEN sold = 1 AND YEARWEEK(cards.updated_at, 1) = YEARWEEK(CURDATE(), 1) THEN 1 ELSE NULL END) as sold_per_week,

            -- Sold cards per month
            COUNT(CASE WHEN sold = 1 AND MONTH(cards.updated_at) = MONTH(CURDATE()) AND YEAR(cards.updated_at) = YEAR(CURDATE()) THEN 1 ELSE NULL END) as sold_per_month,

            -- Total unsold cards (independent of date filter)
            (SELECT COUNT(*) FROM cards AS unsold_cards WHERE unsold_cards.package_id = cards.package_id AND unsold_cards.sold = 0) as total_unsold,

            -- Total cost of sold cards (for today or given date range)
            SUM(CASE WHEN sold = 1 AND DATE(cards.updated_at) = CURDATE() THEN packages.cost ELSE 0 END) as total_sold_cost_today,

            -- Total card price of sold cards (for today or given date range)
            SUM(CASE WHEN sold = 1 AND DATE(cards.updated_at) = CURDATE() THEN packages.card_price ELSE 0 END) as total_card_price_today,

            -- Total cost of sold cards in the date range
            SUM(CASE WHEN sold = 1 AND DATE(cards.updated_at) BETWEEN ? AND ? THEN packages.cost ELSE 0 END) as total_sold_cost_range,

            -- Total card price of sold cards in the date range
            SUM(CASE WHEN sold = 1 AND DATE(cards.updated_at) BETWEEN ? AND ? THEN packages.card_price ELSE 0 END) as total_card_price_range,

            MAX(cards.id) as max_id
        ", [$this->from_date, $this->to_date, $this->from_date, $this->to_date])
            ->groupBy('cards.package_id')
            ->orderBy('max_id', 'DESC')
            ->get();


        return $data;
    }
    public function headings(): array
    {
        return [
            ['الفئة','عدد مبيعات اليوم','عدد مبيعات الاسبوع','عدد مبيعات الشهر','اجمالي مبيعات اليوم','المتبقي']
        ];

    }

    public function map($process): array
    {

        return [
            [
                $process->full_name,
                $process->sold_per_day,
                $process->sold_per_week,
                $process->sold_per_month,
                $process->total_card_price_range ? $process->total_card_price_range :  $process->total_card_price_today,
                $process->total_unsold


            ]

        ];
    }

}
