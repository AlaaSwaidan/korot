<?php

use Modules\Company\Http\Controllers\Card\CardController;
use Modules\Company\Http\Controllers\Card\UploadedCardController;
use App\Models\UploadedCard;
use App\Http\Requests\Admin\AddCardRequest;
use Illuminate\Http\Request;

/*begin---cards*/
Route::group(['prefix' => '/admin', 'as' => 'admin.', 'middleware' => ['CheckActiveSession','admin:admin,/admin/login'] ], static function () {

    Route::post('/update-uploaded-cards', function(Request $request) {
        if ($request->column == "serial_number"){
            $validator = Validator::make($request->all(), [
                'serial_number'    => 'required|numeric',
            ]);
        }elseif ($request->column == "end_date"){
            $validator = Validator::make($request->all(), [
                'end_date'              => 'required|date_format:Y-m-d',
            ]);
        }elseif ($request->column == "card_number"){
            $validator = Validator::make($request->all(), [
                'card_number'             => 'required|unique:cards,card_number,'. $request->id,

            ]);
        }
        if (isset($validator) && $validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        $card = UploadedCard::find($request->id);
        $card->{$request->column} = $request->value;
        $card->save();
        $check = false;
        if (\App\Models\Card::where('card_number',$card->card_number)->OrWhere('serial_number',$card->serial_number)->count() == 0){
            $card->update([
                'error'=>0
            ]);
            $check = true;
        }

        return response()->json(['success' => true , 'check'=>$check]);
    });
 Route::post( '/sold-cards/transaction-excel', [CardController::class,"excel"])->name('sold-cards.transaction-excel');

Route::post( '/sold-cards/recover', [CardController::class,"sold_cards_recover"])->name('sold-cards.recover');
Route::get( '/imported-cards/index', [CardController::class,"imported_cards"])->name('imported-cards.index');
Route::get( '/saled-cards/index', [CardController::class,"saled_cards"])->name('saled-cards.index');
Route::get( '/duplicated-cards/index', [CardController::class,"duplicated_cards"])->name('duplicated-cards.index');
Route::get( '/reports-cards/index', [CardController::class,"reports_cards"])->name('reports-cards.index');
Route::get( '/reports-sales-cards/index', [CardController::class,"reports_sales_cards"])->name('reports-sales-cards.index');
Route::get( '/reports-sales-cards/search', [CardController::class,"reports_sales_cards_search"])->name('reports-sales-cards.search');
Route::post( '/reports/cards-reports-excel', [CardController::class,"cards_excel"])->name('reports.cards-reports-excel');
Route::post( '/reports/sales-cards-reports-excel', [CardController::class,"reports_excel"])->name('reports.sales-cards-reports-excel');



Route::resource('{package}/cards', CardController::class, ['except' => ['destroy','edit','update']]);
Route::get( '/cards/search/{package}', [CardController::class,"search_card"])->name('cards.search');//export cards
Route::post( '/cards/export', [CardController::class,"export"])->name('cards.export');//export cards
Route::post( '/cards/import', [CardController::class,"import"])->name('cards.import');//export cards
Route::post( '/cards/delete-all-store', [CardController::class,"delete_all_store"])->name('cards.delete-all-store');//export cards
Route::post( '/cards/destroy', [CardController::class,"destroy"])->name('cards.destroy');
Route::post( '/cards/selected/destroy', [CardController::class,"destroy_selected_rows"])->name('cards.selected.destroy');

Route::get( '/cards/edit/{card}', [CardController::class,"edit"])->name('cards.edit');
Route::patch( '/cards/update/{card}', [CardController::class,"update"])->name('cards.update');
Route::get( '/sold-cards/index', [CardController::class,"sold_cards"])->name('sold-cards.index');
Route::get( '/sold-cards/search', [CardController::class,"search"])->name('sold-cards.search');
Route::get( '/package-sold-cards/index/{package}', [CardController::class,"package_sold_cards"])->name('package-sold-cards.index');
Route::get( '/lowest-seller-cards/index', [CardController::class,"lowest_seller_cards"])->name('lowest-seller-cards.index');
Route::get( '/most-seller-cards/index', [CardController::class,"most_seller_cards"])->name('most-seller-cards.index');
Route::get( '/uploaded-card-index/index/{package}', [CardController::class,"uploaded_card_index"])->name('uploaded-card-index.index');
Route::get( '/uploaded-card-index-errors/index/{package}', [CardController::class,"uploaded_card_index_errors"])->name('uploaded-card-index-errors.index');


    Route::get('/cards/sold-cards-pdf/{card}', [CardController::class, "generate_pdf"])->name('cards.sold-cards-pdf');


    Route::get( '/uploaded-card-index/store/{package}', [UploadedCardController::class,"store"])->name('uploaded-card-index.store');
    Route::get( '/uploaded-card-index/cancel/{package}', [UploadedCardController::class,"cancel"])->name('uploaded-card-index.cancel');
    Route::get( '/uploaded-card-index/edit/{card}', [UploadedCardController::class,"edit"])->name('uploaded-card-index.edit');
    Route::patch( '/uploaded-card-index/update/{card}', [UploadedCardController::class,"update"])->name('uploaded-card-index.update');
    Route::post( '/uploaded-card-index/destroy', [UploadedCardController::class,"destroy"])->name('uploaded-card-index.destroy');
    Route::post( '/uploaded-card-index/selected/destroy', [UploadedCardController::class,"destroy_selected_rows"])->name('uploaded-card-index.selected.destroy');
});
/*end -- cards*/

