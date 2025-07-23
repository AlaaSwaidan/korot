<?php

namespace Modules\Collections\Repositories;

use Modules\Transfers\Entities\Transfer;

class CollectionAdminRepository
{


    public function store_collection($request,$admin)
    {
        try {


            $request['providerable_id']=auth()->guard('admin')->user()->id;
            $request['providerable_type'] = "App\Models\Admin";
            $request['userable_id']=$admin->id;
            $request['userable_type']=get_class($admin);
            $request['type']="collection";
            $request['collection_total']=$admin->collection_total + $request->amount;
            $request['balance_total']=$admin->balance;
            $request['indebtedness']= $admin->indebtedness != 0 ? $admin->indebtedness - $request->amount : 0;

            $transfer = Transfer::create($request->all());
            $transfer->update([
                'collection_id'=>"S".$transfer->id
            ]);
            add_journals($transfer->id,"collection");

            $admin->update([
                'collection_total'=>$admin->collection_total + $request->amount,
                'indebtedness'=>$admin->indebtedness != 0 ? $admin->indebtedness - $request->amount : 0,
            ]);
            auth()->guard('admin')->user()->update([
                'collection_total'=>auth()->guard('admin')->user()->collection_total + $request->amount,
            ]);
            updateTransfer($transfer,$admin);
            return $transfer;
        } catch (\Exception $exception) {
            return redirect()->route('admin.collections.index','type=admins')->with('warning', 'Error , contact system');
        }
    }




}
