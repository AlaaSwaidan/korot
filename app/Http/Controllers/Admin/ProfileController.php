<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    public function editProfile() {

        $admin = Auth::guard('admin')->user();
        return view('admin.profile.edit_profile', compact('admin'));
    }


    public function updateProfile(Request $request) {

        $this->validate($request, [
            'name'  => 'required|max:191',
            'email' => 'required|email|max:191|unique:admins,email,'. Auth::guard('admin')->user()->id,
            'phone' => 'required|max:20|unique:admins,phone,'. Auth::guard('admin')->user()->id,

        ]);
        $updated = Auth::guard('admin')->user()->update($request->all());
        return $updated ?
            redirect()->back()->with('success', trans('messages.updateOK')) :
            redirect()->back()->with('warning', trans('messages.updateNO'));
    }

    public function changePassword() {

        $admin = Auth::guard('admin')->user();
        return view('admin.profile.change_password', compact('admin'));
    }

    public function updatePassword(Request $request) {

        $request->validate([
            'current_password'  => 'required|min:3|max:191',
            'new_password'      => 'required|min:3|max:191',
            'password_confirm'  => 'same:new_password',
        ]);

        if (!(Hash::check($request->current_password, Auth::guard('admin')->user()->password)))
            return redirect()->back()->with('danger', 'كلمة المرور التي أدخلتها لا تتطابق مع كلمة المرور الخاصة بك');

        if( strcmp($request->current_password, $request->new_password) == 0 )
            return redirect()->back()->with('danger', 'كلمة المرور الجديدة لا يمكن ان تكون مطابقة للحالية, اختر كلمة مرور اخرى');

//        update-password-finally ^^

        $updated = Auth::guard('admin')->user()->update(['password' => $request->new_password]);

        return $updated
            ? redirect()->back()->with('success', 'تم تغيير كلمة المرور بنجاح')
            : redirect()->back()->with('warning', 'حدث خطأ ما, برجاء المحاولة مرة اخرى');
    }


}
