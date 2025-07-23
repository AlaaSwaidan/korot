<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{

    public function __construct()
    {

       $this->middleware('permission:edit_settings', ['only' => ['index','update']]);


    }
    public function index() {

        $setting = Setting::find(1);
        return view('admin.settings.edit', compact('setting'));
    }
    public function update(SettingRequest $request, Setting $setting) {


        $request['version_status'] = isset($request->version_status) ? true : false;
        $request['shutdown_app'] = isset($request->shutdown_app) ? true : false;
        $data = $setting->update($request->all());

        return back()->with('success', trans('messages.updateOK')) ;
    }

}
