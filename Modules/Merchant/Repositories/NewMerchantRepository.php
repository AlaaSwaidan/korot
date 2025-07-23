<?php

namespace Modules\Merchant\Repositories;

use App\Models\Merchant;

class NewMerchantRepository
{

    public function index()
    {
        $data = Merchant::Order()->where('approve',0)->paginate(20)->appends(request()->except('page'));
        return $data;
    }

    public function accept_approve($request)
    {
        try {
            $data = Merchant::find($request->id);
            $deleted = $data->update(['approve'=>1,'active'=>1]);
            return $deleted;
        } catch (\Exception $exception) {
            return redirect()->route('admin.merchants.not-approved')->with('warning', 'Error , contact system');
        }
    }
    public function destroy($request)
    {
        try {
            $data = Merchant::find($request->id);
            $deleted = $data->delete();
            return $deleted;
        } catch (\Exception $exception) {
            return redirect()->route('admin.merchants.not-approved')->with('warning', 'Error , contact system');

        }
    }
    public function destroy_selected_rows($request)
    {
        try {
            $data = Merchant::whereIn('id',$request->ids);
            $deleted = $data->delete();
            return $deleted;
        } catch (\Exception $exception) {
            return redirect()->route('admin.merchants.not-approved')->with('warning', 'Error , contact system');

        }
    }

}
