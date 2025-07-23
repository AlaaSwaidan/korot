<?php

namespace App\Imports;

use App\Models\Card;
use App\Models\Statistic;
use App\Models\UploadedCard;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class CardsImport implements ToCollection  ,WithHeadingRow
{

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    protected $package_id;

    function __construct($package_id) {
        $this->package_id = $package_id;
    }
//    public function rules(): array
//    {
//        return [
//            '*.serial_number'              => 'required|numeric',
//            '*.card_number'              => 'required|regex:/^[0-9 ]+$/|unique:cards',
//            '*.end_date'              => 'required|date_format:Y-m-d',
//        ];
//    }
//    public function model(array $row)
//    {
//
//
//        return new Card([
//            'card_number'     => $row['card_number'],
//            'serial_number'    => $row['serial_number'],
//            'end_date' => $row['end_date'],
//            'package_id' => $this->package_id,
//        ]);
//    }

    public function collection(Collection $rows)
    {

//        Validator::make($rows->toArray(), [
//            '*.card_number' => 'required|numeric',
//            '*.serial_number' => 'required|regex:/^[0-9 ]+$/|unique:cards',
//            '*.end_date' => 'required',
//        ])->validate();


        foreach ($rows as $row) {

            if (!isset($row)) {
                return null;
            }
        $time_input =$row['end_date'] == "" ? null :  strtotime($row['end_date']) ;
        $date_input = $row['end_date'] == "" ? null :  date('Y-m-d', $time_input);
          $cards = Card::where('card_number',$row['card_number'])->where('serial_number',$row['serial_number'])->count();
          $serial = Card::where('serial_number',$row['serial_number'])->count();
          $number = Card::where('card_number',$row['card_number'])->count();

         if (($row['card_number'] == '' || $row['serial_number'] == '' || $row['end_date'] == '')||
              $cards > 0 || $serial > 0 || $number > 0 ){
             if ($cards > 0){
                 $reason = "سبب الفشل إن رقم البطاقة والرقم التسلسلي مكررين ";
             }elseif ($serial > 0){
                 $reason = "سبب الفشل إن الرقم التسلسلي مكرر ";
             }elseif ($number > 0){
                 $reason = "سبب الفشل إن رقم البطاقة مكرر ";
             }else{
                 $reason = "سبب الفشل إن رقم البطاقة / الرقم التسلسلي مطلوب ";
             }
              UploadedCard::create([
                  'card_number'     => $row['card_number'],
                  'serial_number'    => $row['serial_number'],
                  'end_date' =>$date_input,
                  'package_id' => $this->package_id,
                  'reason' => $reason,
                  'error' => 1,
              ]);
          }else{
              UploadedCard::create([
                  'card_number'     => $row['card_number'],
                  'serial_number'    => $row['serial_number'],
                  'end_date' =>$date_input,
                  'package_id' => $this->package_id,
                  'error' => 0,
              ]);
          }


//             Card::create([
//                'card_number'     => $row['card_number'],
//                'serial_number'    => $row['serial_number'],
//                'end_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['end_date']),
//                'package_id' => $this->package_id,
//            ]);
//            $statistics = Statistic::find(1);
//            $statistics->update([
//                'card_numbers'=>$statistics->card_numbers + 1
//            ]);
        }
        UploadedCard::where('card_number','')->where('serial_number','')->delete();
    }
    public function chunkSize(): int
    {
        return 1000;
    }
}
