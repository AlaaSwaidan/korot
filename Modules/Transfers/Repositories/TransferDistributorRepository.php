<?php

namespace Modules\Transfers\Repositories;

use Modules\Collections\Repositories\CollectionRepository;
use Modules\Transfers\Entities\Transfer;
use PDF;

class TransferDistributorRepository
{
    public $repositoryCollection;
    public function __construct()
    {
        $this->repositoryCollection = new CollectionRepository();
    }

    public function store_transfer($request,$distributor)
    {
        try {

            if (auth()->guard('admin')->user()->balance < $request->amount){
                return false;
            }
            $request['providerable_id']=auth()->guard('admin')->user()->id;
            $request['providerable_type'] = "App\Models\Admin";
            $request['userable_id']=$distributor->id;
            $request['userable_type']=get_class($distributor);
            $request['type']="transfer";
            $request['transfers_total']=$distributor->transfer_total + $request->amount;
            $request['balance_total']=$distributor->balance + $request->amount;
            $request['indebtedness']=$request->transfer_type == "delay" ? $distributor->indebtedness + $request->amount : 0;

            $transfer = Transfer::create($request->all());

            $distributor->update([
                'balance'=>$distributor->balance + $request->amount,
                'transfer_total'=>$distributor->transfer_total + $request->amount,
                'indebtedness'=>$request->transfer_type == "delay" ? $distributor->indebtedness + $request->amount : $distributor->indebtedness,
            ]);
            auth()->guard('admin')->user()->update([
                'balance'=>auth()->guard('admin')->user()->balance - $request->amount,
                'transfer_total'=>auth()->guard('admin')->user()->transfer_total + $request->amount,
            ]);
            updateTransfer($transfer,$distributor);
//            if ($request->transfer_type  == "fawry"){
//                $this->repositoryCollection->store_collection($request,$distributor);
//            }
            return $transfer;
        } catch (\Exception $exception) {
            return redirect()->route('admin.transfers.index','type=distributors')->with('warning', 'Error , contact system');
        }
    }


}
