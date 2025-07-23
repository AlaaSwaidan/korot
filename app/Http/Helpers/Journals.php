<?php
use App\Models\Journal;
use Modules\Transfers\Entities\Transfer;
use App\Models\PurchaseOrder;
function add_journals($invoice_id,$type){
    if ($type == "collection"){
        $data = Transfer::find($invoice_id);
        if ($data->bank_id){
            Journal::create([
                'invoice_id'=>$data->collection_id,
                'type'=>$type,
                'bank_id'=>$data->bank_name,
                'account_number'=>$data->bank->account_number,
                'credit'=>$data->amount,
                'debit'=>0,
                'balance'=>$data->bank->balance + $data->amount,
            ]);

            $data->bank->update([
                'balance' => $data->bank->balance + $data->amount
            ]);
        }


    }elseif ($type == "purchases"){
        $data =  PurchaseOrder::find($invoice_id);
        if ($data->bank_id){
            Journal::create([
                'invoice_id'=>$data->invoice_id,
                'type'=>$type,
                'bank_id'=>$data->bank_id,
                'account_number'=>$data->bank->account_number,
                'credit'=>0,
                'debit'=>$data->total_after_tax,
                'balance'=>$data->bank->balance - $data->total_after_tax,
            ]);
            $data->bank->update([
                'balance' => $data->bank->balance - $data->total_after_tax
            ]);
        }

    }elseif ($type == "outgoings"){
        $data =  PurchaseOrder::find($invoice_id);
        if ($data->bank_id){
            Journal::create([
                'invoice_id'=>$data->invoice_id,
                'type'=>$type,
                'bank_id'=>$data->bank_id,
                'account_number'=>$data->bank->account_number,
                'credit'=>0,
                'debit'=>$data->total_after_tax,
                'balance'=>$data->bank->balance - $data->total_after_tax,
            ]);
            $data->bank->update([
                'balance' => $data->bank->balance - $data->total_after_tax
            ]);
        }

    }

}
