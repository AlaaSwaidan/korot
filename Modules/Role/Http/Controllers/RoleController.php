<?php

namespace Modules\Role\Http\Controllers;

use App\Models\Module;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Role\Http\Requests\RolesRequest;
use Modules\Role\Repositories\RoleRepository;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public $repository;

    public function __construct()
    {
        $this->middleware('permission:view_roles');
        $this->middleware('permission:create_roles', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_roles', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_roles', ['only' => ['destroy']]);

        $this->repository = new RoleRepository();
    }

    public function index()
    {
        $data = $this->repository->index();
        return view('role::roles.index', compact('data'));
    }


    public function create()
    {

        $modules = Module::all();

        return view('role::roles.create', compact('modules'));
    }


    public function store(RolesRequest $request)
    {
        $data = $this->repository->store($request);
        return $data ?
            redirect()->route('admin.roles.index')->with('success', trans('messages.updateOK')) :
            redirect()->route('admin.roles.index')->with('warning', trans('messages.updateNO'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Role $role)
    {

        try {
            $modules = Module::all();
        } catch (\Exception $e) {

            return redirect()->back()->with(['message' => 'sorry please try again later', 'type' => 'error']);
        }

        return view('role::roles.edit', compact('role', 'modules'));
    }

    public function show(Role $role)
    {

        try {
            $modules = Module::all();
        } catch (\Exception $e) {

            return redirect()->back()->with(['message' => 'sorry please try again later', 'type' => 'error']);
        }

        return view('role::roles.show', compact('role', 'modules'));
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(RolesRequest $request, Role  $role)
    {
     $updated =    $this->repository->update($request,$role);
        return $updated ?
            redirect()->route('admin.roles.index')->with('success', trans('messages.updateOK')) :
            redirect()->route('admin.roles.index')->with('warning', trans('messages.updateNO'));
    }


    public function destroy(Request $request)
    {


        $deleted = $this->repository->destroy($request);

        $url = route('admin.roles.index');
        return $deleted
            ? json_encode(['code' => '1', 'url' => $url])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
}
