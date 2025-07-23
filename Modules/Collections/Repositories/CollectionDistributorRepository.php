<?php

namespace Modules\Collections\Repositories;

use Modules\Transfers\Entities\Transfer;
use PDF;

class CollectionDistributorRepository
{


    public function store_collection($request,$distributor)
    {
        try {


            $request['providerable_id']=auth()->guard('admin')->user()->id;
            $request['providerable_type'] = "App\Models\Admin";
            $request['userable_id']=$distributor->id;
            $request['userable_type']=get_class($distributor);
            $request['type']="collection";
            $request['collection_total']=$distributor->collection_total + $request->amount;
            $request['balance_total']=$distributor->balance;
            $request['indebtedness']= $distributor->indebtedness != 0 ? $distributor->indebtedness - $request->amount : 0;

            $transfer = Transfer::create($request->all());
            $transfer->update([
                'collection_id'=>"S".$transfer->id
            ]);
            add_journals($transfer->id,"collection");
            $distributor->update([
                'collection_total'=>$distributor->collection_total + $request->amount,
                'indebtedness'=>$distributor->indebtedness != 0 ? $distributor->indebtedness - $request->amount : 0,
            ]);
            auth()->guard('admin')->user()->update([
                'collection_total'=>auth()->guard('admin')->user()->collection_total + $request->amount,
            ]);
            updateTransfer($transfer,$distributor);
            return $transfer;
        } catch (\Exception $exception) {
            return redirect()->route('admin.collections.index','type=distributors')->with('warning', 'Error , contact system');
        }
    }


}
