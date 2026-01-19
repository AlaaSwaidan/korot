<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CountrySettingRequest;
use App\Models\CountrySetting;
use Illuminate\Http\Request;

class CountrySettingsController extends Controller
{
    //
    public function index(){
        $data = CountrySetting::orderBy('id','desc')->paginate(10);
        return view('admin.country_settings.index',compact('data'));
    }

    public function create()
    {
        return view('admin.country_settings.create');
    }
//
    public function store(CountrySettingRequest $request) {

        $data = CountrySetting::create($request->all());

        return $data ?
            redirect()->route('admin.country-settings.index')->with('success', trans('messages.addOK')) :
            redirect()->route('admin.country-settings.index')->with('warning', trans('messages.addNO'));
    }

    public function edit(CountrySetting $country_setting) {

        return view('admin.country_settings.edit', compact('country_setting'));
    }

    public function update(CountrySettingRequest $request, CountrySetting $country_setting) {

        $updated = $country_setting->update($request->all());

        return $updated ?
            redirect()->route('admin.country-settings.index')->with('success', trans('messages.updateOK')) :
            redirect()->route('admin.country-settings.index')->with('warning', trans('messages.updateNO'));
    }




    public function destroy(Request $request) {

        $data = CountrySetting::find($request->id);


        $deleted = $data->delete();
        $url = route('admin.country-settings.index');

        return $deleted
            ? json_encode(['code' => '1', 'url' => $url])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
}
