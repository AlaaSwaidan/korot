<?php

namespace Modules\Accounts\Repositories;

use App\Models\Bank;
use App\Models\Outgoing;
use App\Models\Supplier;
use Carbon\Carbon;

class OutgoingsRepository
{

    public function index()
    {
        $data = Outgoing::Order()->paginate(20)->appends(request()->except('page'));
        return $data;
    }
    public function store($request)
    {
        try {
            $sum = $request->amount * $request->quantity;
            $total = $request->discount ? ($sum - ($request->discount * $sum /100)) : $sum;
            $tax = $request->tax ? $total + ($total * $request->tax /100) : $total;
            $request['total']=$tax;


            $outgoing = Outgoing::create($request->all());
            $outgoing->update([
                'invoice_id'=>"E".$outgoing->id
            ]);
            return $outgoing;

        } catch (\Exception $exception) {
            return redirect()->route('admin.outgoings.index')->with('warning', 'Error , contact system');
        }
    }

    public function update($request, $outgoing)

    {
        try {
            $sum = $request->amount * $request->quantity;
            $total = $request->discount ? ($sum - ($request->discount * $sum /100)) : $sum;
            $tax = $request->tax ? $total + ($total * $request->tax /100) : $total;
            $request['total']=$tax;
            $updated = $outgoing->update($request->all());
            return $updated;
        } catch (\Exception $exception) {
            return redirect()->route('admin.outgoings.index')->with('warning', 'Error , contact system');

        }

    }
    public function confirm($request, $outgoing)

    {
        try {
            $sum = $request->amount * $request->quantity;
            $total = $request->discount ? ($sum - ($request->discount * $sum /100)) : $sum;
            $tax = $request->tax ? $total + ($total * $request->tax /100) : $total;
            $request['total']=$tax;
            $request['confirm']=1;
            $updated = $outgoing->update($request->all());
            add_journals($outgoing->id,"outgoings");
            return $updated;
        } catch (\Exception $exception) {
            return redirect()->route('admin.outgoings.index')->with('warning', 'Error , contact system');

        }

    }

    public function destroy($request)
    {
        try {
            $data = Outgoing::find($request->id);
            $deleted = $data->delete();
            return $deleted;
        } catch (\Exception $exception) {
            return redirect()->route('admin.outgoings.index')->with('warning', 'Error , contact system');

        }
    }
    public function destroy_selected_rows($request)
    {
        try {
            $data = Outgoing::whereIn('id',$request->ids)->where('confirm',0);
            $deleted = $data->delete();
            return $deleted;
        } catch (\Exception $exception) {
            return redirect()->route('admin.outgoings.index')->with('warning', 'Error , contact system');

        }
    }

}
