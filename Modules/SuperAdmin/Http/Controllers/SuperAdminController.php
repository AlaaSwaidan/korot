<?php

namespace Modules\SuperAdmin\Http\Controllers;

use App\Models\Admin;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SuperAdmin\Http\Requests\SuperAdminRequest;
use Modules\SuperAdmin\Repositories\SuperAdminRepository;

class SuperAdminController extends Controller
{


    public $repository;

    public function __construct()
    {
        $this->middleware('permission:view_super_admins');
        $this->middleware('permission:create_super_admins', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_super_admins', ['only' => ['edit','showChangePasswordForm','updateAdminPassword', 'update']]);
        $this->middleware('permission:delete_super_admins', ['only' => ['destroy']]);

        $this->repository = new SuperAdminRepository();

    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = $this->repository->index();
        return view('superadmin::super_admins.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('superadmin::super_admins.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(SuperAdminRequest $request)
    {
        $data = $this->repository->store($request);
        return $data ?
            redirect()->route('admin.super-admins.index')->with('success', trans('messages.addOK')) :
            redirect()->route('admin.super-admins.index')->with('warning', trans('messages.addNO'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Admin $superAdmin)
    {
        return view('superadmin::super_admins.show',compact('superAdmin'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Admin $superAdmin)
    {
        return view('superadmin::super_admins.edit',compact('superAdmin'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(SuperAdminRequest $request, Admin $superAdmin)
    {
        $updated = $this->repository->update($request, $superAdmin);
        return $updated ?
            redirect()->route('admin.super-admins.index')->with('success', trans('messages.updateOK')) :
            redirect()->route('admin.super-admins.index')->with('warning', trans('messages.updateNO'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request)
    {
        $deleted = $this->repository->destroy($request);
        $url = route('admin.super-admins.index');
        return $deleted
            ? json_encode(['code' => '1', 'url' => $url])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
    public function showChangePasswordForm(Admin $superAdmin){
        return view('superadmin::super_admins.change_password', compact('superAdmin'));

    }
    public function updateAdminPassword(Request $request, Admin $superAdmin) {

        $request->validate([
            'new_password'      => 'required|min:3|max:191',
            'password_confirm'  => 'same:new_password',
        ]);

        $updated =    $this->repository->update_password($request,$superAdmin);
        return $updated ?
            redirect()->route('admin.super-admins.index')->with('success', 'تم تغيير كلمة مرور مشرف بنجاح') :
            redirect()->route('admin.super-admins.index')->with('warning', 'حدث خطأ ما, برجاء المحاولة مرة اخرى');
    }
}
