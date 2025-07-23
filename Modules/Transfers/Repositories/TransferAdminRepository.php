<?php

namespace Modules\Transfers\Repositories;

use App\Models\Statistic;
use Illuminate\Support\Facades\Auth;
use Modules\Collections\Repositories\CollectionRepository;
use Modules\Transfers\Entities\Transfer;

class TransferAdminRepository
{

    public $repositoryCollection;
    public function __construct()
    {
        $this->repositoryCollection = new CollectionRepository();
    }
    public function store_transfer($request,$admin)
    {
        try {


            $request['providerable_id']=auth()->guard('admin')->user()->id;
            $request['providerable_type'] = "App\Models\Admin";
            $request['userable_id']=$admin->id;
            $request['userable_type']=get_class($admin);
            $request['type']="transfer";
            $request['transfers_total']=$admin->transfer_total + $request->amount;
            $request['balance_total']=$admin->balance + $request->amount;
            $request['indebtedness']=$request->transfer_type == "delay" ? $admin->indebtedness + $request->amount : 0;

            $transfer = Transfer::create($request->all());

            $admin->update([
                'balance'=>$admin->balance + $request->amount,
                'transfer_total'=>$admin->transfer_total + $request->amount,
                'indebtedness'=>$request->transfer_type == "delay" ? $admin->indebtedness + $request->amount : $admin->indebtedness,
            ]);
            $superAdmin = Auth::guard('admin')->user();
            $superAdmin->update([
                'transfer_total'=>$superAdmin->transfer_total + $request->amount,
            ]);

            updateTransfer($transfer,$admin);

//            if ($request->transfer_type  == "fawry"){
//                $this->repositoryCollection->store_collection($request,$admin);
//            }
            $statistics = Statistic::find(1);

            $statistics->update([
                'digital_balance' => $statistics->digital_balance - $transfer->amount
            ]);

            return $transfer;
        } catch (\Exception $exception) {
            return redirect()->route('admin.transfers.index','type=admins')->with('warning', 'Error , contact system');
        }
    }




}
