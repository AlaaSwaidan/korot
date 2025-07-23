<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CardSoldExport;
use App\Http\Controllers\Controller;
use App\Imports\FilteredCardsExport;
use App\Jobs\ExportCardSoldJob;
use App\Models\Card;
use App\Models\Order;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExportSuspendedCardController extends Controller
{
    //
    public function importAndFilter(Request $request)
    {
        // 1. Validate uploaded file
//        $request->validate([
//            'file' => 'required|file|mimes:xlsx,csv,xls'
//        ]);

        // 2. Load the file into a collection
        // Get the absolute local path to the file
        $pathToFile = public_path('admin/filtered_cards_cleaned.xlsx');

        // Pass that path to Excel::toCollection()
        $collection = Excel::toCollection(null, $pathToFile)->first();        // $collection is a Laravel Collection of rows

        // 3. Initialize an array (or collection) for rows that DO exist in DB
        $validRows = [];

        // 4. Loop through each row
        //    Assuming columns in Excel: card_number, serial_number, end_date
        foreach ($collection as $index => $row) {

            if ($index === 0) {
                continue; // skip the header row
            }
            // adjust indices/names depending on how your Excel columns are structured
            $cardNumber   = $row[0];
            $serialNumber = $row[1];
            $endDate      = $row[2];
            $createdAt    = $row[3];

            // Check if such a card exists in 'cards' table
            // NOTE: Adjust your where conditions to match how your DB stores them
            $exists = Card::where('card_number', $cardNumber)
                ->where('serial_number', $serialNumber)
                ->exists();

            if (!$exists) {
                // If row exists in DB, keep it
                $validRows[] = [
                    'card_number'   => $cardNumber,
                    'serial_number' => $serialNumber,
                    'end_date'      => $endDate,
                    'created_at'      => $createdAt,
                ];
            }
            // else skip
        }

        // Now $validRows holds only the rows that exist in your cards table

        // 5. Optionally export or display the valid rows

        // Example: Return them as JSON (just for demonstration)
//        return response()->json([
//            'status' => 'success',
//            'valid_rows_count' => count($validRows),
//            'valid_rows' => $validRows,
//        ]);
        return Excel::download(new FilteredCardsExport($validRows), 'filtered_cards.'.randNumber(4)."."."xlsx");

    }


public function export()
    {
        return view('welcome');
//        return Excel::download(new CardSoldExport(), 'cards.xlsx');
    }
    public function post_export()
    {
        // Chunk the orders to prevent memory issues
        $chunkSize = 100; // Adjust as needed

//        Order::whereIn('paid_order', ['cancel', 'not_paid'])
//            ->whereHas('card', function ($query) {
//                $query->where('sold', 1);
//            })
//            ->whereDoesntHave('card.orders', function ($query) {
//                $query->where('paid_order', 'paid');
//            })
//            ->whereDate('created_at', '<', '2025-02-06') // Filters created_at before 6th Feb 2025
//            ->chunkById($chunkSize, function ($orders) {
//                // Get the card IDs from the orders
//                $cardIds = $orders->pluck('card.card_number')->unique();
//
//                if ($cardIds->isNotEmpty()) {
//                    // Update the cards table in bulk
//                    DB::table('cards')->whereIn('card_number', $cardIds)->update(['sold' => 0]);
//                }
//            });
        $result = DB::table('packages')
            ->join('cards', 'packages.id', '=', 'cards.package_id')
            ->where('packages.status', 1)
            ->selectRaw('
                SUM(CASE WHEN cards.sold = 0 THEN packages.cost ELSE 0 END) as total_cost,
                SUM(packages.cost) as all_total_cost
            ')
            ->first();

        $costs = $result->total_cost;
        $all_costs = $result->all_total_cost;
dd($costs,$all_costs);
//        DB::table('cards')->whereIn('card_number', $cards)->update(['sold'=>0]);
//dd($cards);
        return response()->json(['message' => 'Cards updated successfully']);
//        Excel::queue(new CardSoldExport(), 'september_cards.xlsx');
////        $fileName = 'cards_' . time() . '.xlsx'; // or any logic to generate file names
////        ExportCardSoldJob::dispatch($fileName); // Dispatch the job to queue
//        return response()->json(['message' => 'Export started. The file will be available shortly.']);
//
//
//        $cards = Order::whereIn('paid_order', ['cancel', 'not_paid'])
//            ->whereHas('card', function ($query) {
//                $query->where('sold', 1);
//            })
//            ->whereDoesntHave('card.orders', function ($query) {
//                $query->where('paid_order', 'paid');
//            })
//            ->whereDate('end_date', '>', '2025-02-06') // Get cards with end_date after 6th Feb 2025
//            ->pluck('card_number'); // Get only card numbers
//
//// Update the 'sold' status in the 'card' table
//        Card::whereIn('card_number', $cards)->update(['sold' => 0]);

//        return Excel::download(new CardSoldExport(), 'cards.xlsx');
    }
}
