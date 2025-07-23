<?php

namespace Modules\Company\Http\Controllers\Category;

use App\Models\Store;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Company\Http\Requests\CategoryRequest;
use Modules\Company\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public $repository;
    public function __construct()
    {
        $this->middleware('permission:view_categories');
        $this->middleware('permission:create_categories', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_categories', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_categories', ['only' => ['destroy','destroy_selected_rows']]);

        $this->repository = new CategoryRepository();
    }
    public function index(Store $company)
    {
        $data = $this->repository->index($company);
        return view('company::categories.index',compact('data','company'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Store $company)
    {
        return view('company::categories.create',compact('company'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CategoryRequest $request, Store $company)
    {
        $data = $this->repository->store($request,$company);
        return $data ?
            redirect()->route('admin.categories.index',$company->id)->with('success', trans('messages.addOK')) :
            redirect()->route('admin.categories.index',$company->id)->with('warning', trans('messages.addNO'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Store $company)
    {
        return view('company::categories.show',compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Store $store)
    {
        return view('company::categories.edit',compact('store'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(CategoryRequest $request, Store $store)
    {
        $updated = $this->repository->update($request, $store);
        return $updated ?
            redirect()->route('admin.categories.index',$store->parent_id)->with('success', trans('messages.updateOK')) :
            redirect()->route('admin.categories.index',$store->parent_id)->with('warning', trans('messages.updateNO'));
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
