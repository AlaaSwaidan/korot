<?php

namespace Modules\Accounts\Http\Controllers;

use App\Models\Bank;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Accounts\Http\Requests\CreateBankRequest;
use Modules\Accounts\Repositories\BankRepository;

class BanksController extends Controller
{
    public $repository ;

    public function __construct()
    {
        $this->middleware('permission:view_storages');
        $this->middleware('permission:create_storages', ['only' => ['store','create']]);
        $this->middleware('permission:update_storages', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_storages', ['only' => ['destroy_selected_rows','destroy']]);


        $this->repository = new BankRepository();
    }

    public function index()
    {
        $data = $this->repository->index();
        return view('accounts::banks.index',compact('data'));
    }
    public function all_banks()
    {
        $banks = Bank::Order()->get();
        $banks->map(function ($q){
            $q['name_ar']=$q->name['ar'];
            return $q;
        });
        $data['banks']= $banks;
        return json_encode($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {

        return view('accounts::banks.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateBankRequest $request)
    {
        $data = $this->repository->store($request);
        return $data ?
            redirect()->route('admin.banks.index')->with('success', trans('messages.addOK')) :
            redirect()->route('admin.banks.index')->with('warning', trans('messages.addNO'));
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
    public function edit(Bank $bank)
    {

        return view('accounts::banks.edit',compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(CreateBankRequest $request, Bank $bank)
    {
        $updated = $this->repository->update($request, $bank);
        return $updated ?
            redirect()->route('admin.banks.index')->with('success', trans('messages.updateOK')) :
            redirect()->route('admin.banks.index')->with('warning', trans('messages.updateNO'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request)
    {
        $deleted = $this->repository->destroy($request);
        $url = route('admin.banks.index');

        return $deleted
            ? json_encode(['code' => '1', 'url' => $url])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
    public function destroy_selected_rows(Request $request)
    {
        $deleted = $this->repository->destroy_selected_rows($request);
        $url = route('admin.banks.index');

        return $deleted
            ? json_encode(['code' => '1', 'url' => $url])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
}
