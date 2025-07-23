<?php

namespace Modules\Company\Http\Controllers\Packages;

use App\Models\Package;
use App\Models\Store;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Company\Http\Requests\PackageRequest;
use Modules\Company\Repositories\PackageRepository;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public $repository;
    public function __construct()
    {
        $this->middleware('permission:view_packages');
        $this->middleware('permission:create_packages', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_packages', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_packages', ['only' => ['destroy','destroy_selected_rows']]);

        $this->repository = new PackageRepository();
    }
    public function index(Store $category)
    {
        $data = $this->repository->index($category);
        return view('company::packages.index',compact('data','category'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Store $category)
    {
        return view('company::packages.create',compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(PackageRequest $request,Store $category)
    {
        $data = $this->repository->store($request,$category);
        return $data ?
            redirect()->route('admin.packages.index',$category->id)->with('success', trans('messages.addOK')) :
            redirect()->route('admin.packages.index',$category->id)->with('warning', trans('messages.addNO'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Store $category)
    {
        return view('company::packages.show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Package $package)
    {
        $price = $package->prices()->get();
        return view('company::packages.edit',compact('package','price'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(PackageRequest $request, Package $package)
    {
        $updated = $this->repository->update($request, $package);
        return $updated ?
            redirect()->route('admin.packages.index',$package->store_id)->with('success', trans('messages.updateOK')) :
            redirect()->route('admin.packages.index',$package->store_id)->with('warning', trans('messages.updateNO'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request) {
        $data = $this->repository->destroy($request);

        return $data
            ? json_encode(['code' => '1', 'url' => $data])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
    public function destroy_selected_rows(Request $request) {
        $data = $this->repository->destroy_selected_rows($request);

        return $data
            ? json_encode(['code' => '1', 'url' => $data])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
}
