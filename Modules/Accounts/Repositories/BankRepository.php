<?php

namespace Modules\Accounts\Repositories;

use App\Models\Bank;
use App\Models\Supplier;
use Carbon\Carbon;

class BankRepository
{

    public function index()
    {
        $data = Bank::Order()->paginate(20)->appends(request()->except('page'));
        return $data;
    }
    public function store($request)
    {
        try {

            $bank = Bank::create($request->all());
            return $bank;

        } catch (\Exception $exception) {
            return redirect()->route('admin.banks.index')->with('warning', 'Error , contact system');
        }
    }

    public function update($request, $bank)

    {
        try {

            $updated = $bank->update($request->all());
            return $updated;
        } catch (\Exception $exception) {
            return redirect()->route('admin.banks.index')->with('warning', 'Error , contact system');

        }

    }

    public function destroy($request)
    {
        try {
            $data = Bank::find($request->id);
            $deleted = $data->delete();
            return $deleted;
        } catch (\Exception $exception) {
            return redirect()->route('admin.banks.index')->with('warning', 'Error , contact system');

        }
    }
    public function destroy_selected_rows($request)
    {
        try {
            $data = Bank::whereIn('id',$request->ids)->where('id','!=',1);
            $deleted = $data->delete();
            return $deleted;
        } catch (\Exception $exception) {
            return redirect()->route('admin.banks.index')->with('warning', 'Error , contact system');

        }
    }

}
