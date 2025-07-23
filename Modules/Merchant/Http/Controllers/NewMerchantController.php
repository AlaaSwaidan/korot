<?php

namespace Modules\Merchant\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Merchant\Repositories\NewMerchantRepository;

class NewMerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public $repository ;
    public function __construct()
    {
        $this->middleware('permission:waitingView_merchants');
        $this->middleware('permission:waitingApprove_merchants', ['only' => ['accept_approve']]);
        $this->middleware('permission:waitingDelete_merchants', ['only' => ['destroy','destroy_selected_rows']]);

        $this->repository = new NewMerchantRepository();
    }

    public function index()
    {
        $data = $this->repository->index();
        return view('merchant::new_merchants.index',compact('data'));
    }
    public function accept_approve(Request $request) {

        $deleted = $this->repository->accept_approve($request);
        $url = route('admin.merchants.not-approved');

        return $deleted
            ? json_encode(['code' => '1', 'url' => $url])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
    public function destroy(Request $request) {

        $deleted = $this->repository->destroy($request);
        $url = route('admin.merchants.not-approved');

        return $deleted
            ? json_encode(['code' => '1', 'url' => $url])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
    public function destroy_selected_rows(Request $request) {

        $deleted = $this->repository->destroy_selected_rows($request);
        $url = route('admin.merchants.not-approved');

        return $deleted
            ? json_encode(['code' => '1', 'url' => $url])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('merchant::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('merchant::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('merchant::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */

}
