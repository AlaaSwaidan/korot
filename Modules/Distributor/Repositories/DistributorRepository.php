<?php

namespace Modules\Distributor\Repositories;

use App\Models\Distributor;
use App\Models\UserToken;
use Tymon\JWTAuth\Facades\JWTAuth;

class DistributorRepository
{

    public function index()
    {
        $data = Distributor::Order()->paginate(20)->appends(request()->except('page'));
        return $data;
    }


    public function store($request)
    {
        try {
            $request['active'] = isset($request->status) ? $request->status : 0;

            $request['added_by']=auth()->guard('admin')->user()->id;
            if ( isset($request->photo) && $request->photo ){
                $request['image'] = UploadImage($request->file('photo'), 'distributors', '/uploads/distributors');

            }
            if ( isset($request->identity_photo) && $request->identity_photo ){
                $request['identity_image'] = UploadImage($request->file('identity_photo'), 'distributors', '/uploads/distributors');

            }
            $distributor = Distributor::create($request->all());
            return $distributor;
        } catch (\Exception $exception) {
            return redirect()->route('admin.distributors.index')->with('warning', 'Error , contact system');
        }
    }

    public function update($request, $distributor)

    {
        try {
            if ( isset($request->photo) && $request->photo ){
                @unlink(public_path('uploads/distributors/') . $distributor->image);
                $request['image'] = UploadImage($request->file('photo'), 'distributors', '/uploads/distributors');
            }
            if ( isset($request->identity_photo) && $request->identity_photo ){
                @unlink(public_path('uploads/distributors/') . $distributor->identity_image);
                $request['identity_image'] = UploadImage($request->file('identity_photo'), 'distributors', '/uploads/distributors');

            }
            $request['active'] = isset($request->status) ? $request->status : 0;
            $updated = $distributor->update($request->all());
            return $updated;
        } catch (\Exception $exception) {
            return redirect()->route('admin.distributors.index')->with('warning', 'Error , contact system');

        }

    }

    public function destroy($request)
    {
        try {
            $data = Distributor::find($request->id);
            $deleted = $data->delete();
            return $deleted;
        } catch (\Exception $exception) {
            return redirect()->route('admin.distributors.index')->with('warning', 'Error , contact system');

        }
    }
    public function destroy_token($request)
    {
        try {
            $data = Distributor::find($request->id);
            $get_token = UserToken::where('userable_id', $data->id)
                ->where('userable_type',get_class($data))
                ->orderBy('id', 'desc')
                ->first();
            if($get_token ){
                JWTAuth::manager()->invalidate(new \Tymon\JWTAuth\Token($get_token->access_token), $forceForever = false);
                UserToken::where('userable_id', $data->id)
                    ->where('userable_type',get_class($data))
                    ->delete();
            }

            return $data;
        } catch (\Exception $exception) {
            return redirect()->route('admin.distributors.index')->with('warning', 'Error , contact system');

        }
    }
    public function destroy_selected_rows($request)
    {
        try {
            $data = Distributor::whereIn('id',$request->ids);
            $deleted = $data->delete();
            return $deleted;
        } catch (\Exception $exception) {
            return redirect()->route('admin.distributors.index')->with('warning', 'Error , contact system');

        }
    }

    public function update_password($request, $distributor)
    {
        try {
            $updated = $distributor->update(['password' => $request->new_password]);
            return $updated;
        } catch (\Exception $exception) {
            return redirect()->route('admin.distributors.index')->with('warning', 'Error , contact system');

        }
    }

}
