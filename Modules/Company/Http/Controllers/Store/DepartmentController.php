<?php

namespace Modules\Company\Http\Controllers\Store;

use App\Models\Department;
use App\Models\Store;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Company\Http\Requests\DepartmentRequest;
use Modules\Company\Http\Requests\StoreRequest;
use Modules\Company\Repositories\DepartmentRepository;
use Modules\Company\Repositories\StoreRepository;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public $repository;
    public function __construct()
    {
        $this->middleware('permission:view_departments');
        $this->middleware('permission:create_departments', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_departments', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_departments', ['only' => ['destroy','destroy_selected_rows']]);

        $this->repository = new  DepartmentRepository();
    }

    public function index()
    {
        $data = $this->repository->index();
        return view('company::departments.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $stores = Store::Order()->Main()->get();
        return view('company::departments.create',compact('stores'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(DepartmentRequest $request)
    {
        $data = $this->repository->store($request);
        return $data ?
            redirect()->route('admin.departments.index')->with('success', trans('messages.addOK')) :
            redirect()->route('admin.departments.index')->with('warning', trans('messages.addNO'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Department $department)
    {
        return view('company::departments.show',compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Department $department)
    {
        $stores = Store::Order()->Main()->get();
        return view('company::departments.edit',compact('department','stores'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(DepartmentRequest $request, Department $department)
    {
        //
        $updated = $this->repository->update($request, $department);
        return $updated ?
            redirect()->route('admin.departments.index')->with('success', trans('messages.updateOK')) :
            redirect()->route('admin.departments.index')->with('warning', trans('messages.updateNO'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request)
    {
        $deleted = $this->repository->destroy($request);
        $url = route('admin.departments.index');

        return $deleted
            ? json_encode(['code' => '1', 'url' => $url])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
    public function destroy_selected_rows(Request $request)
    {
        $deleted = $this->repository->destroy_selected_rows($request);
        $url = route('admin.departments.index');

        return $deleted
            ? json_encode(['code' => '1', 'url' => $url])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
}
