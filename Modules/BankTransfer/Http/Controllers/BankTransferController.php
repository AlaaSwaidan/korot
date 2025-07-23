<?php

namespace Modules\BankTransfer\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\BankTransfer\Repositories\BankTransferRepository;
use Modules\Transfers\Entities\Transfer;

class BankTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public $repository;
    public function __construct()
    {
        $type =\request()->type;
        if ($type == "payment"){
            $this->middleware('permission:view_Indebtedness_banks_transfers');
            $this->middleware('permission:accept_Indebtedness_banks_transfers', ['only' => ['accept']]);
            $this->middleware('permission:refuse_Indebtedness_banks_transfers', ['only' => ['refuse']]);

        }elseif ($type == "profits"){
            $this->middleware('permission:view_profits_banks_transfers');
            $this->middleware('permission:accept_profits_banks_transfers', ['only' => ['accept']]);
            $this->middleware('permission:refuse_profits_banks_transfers', ['only' => ['refuse']]);

        }elseif ($type == "recharge"){
            $this->middleware('permission:view_balance_banks_transfers');
            $this->middleware('permission:accept_balance_banks_transfers', ['only' => ['accept']]);
            $this->middleware('permission:refuse_balance_banks_transfers', ['only' => ['refuse']]);

        }
        $this->repository = new BankTransferRepository();
    }
    public function index()
    {
        $type = \request()->type;
        $data = $this->repository->index($type);
        return view('banktransfer::transactions.index',compact('data','type'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function accept(Request $request)
    {
        $data = Transfer::find($request->id);
        $updated = $this->repository->accept($request);

        $url = route('admin.transaction.index','type='.$data->type);
        return $updated
            ? json_encode(['code' => '1', 'url' => $url])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function refuse(Request $request)
    {
        $data = Transfer::find($request->id);
        $updated = $this->repository->refuse($request);

        $url = route('admin.transaction.index','type='.$data->type);
        return $updated
            ? json_encode(['code' => '1', 'url' => $url])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('banktransfer::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('banktransfer::edit');
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
    public function destroy($id)
    {
        //
    }
}
