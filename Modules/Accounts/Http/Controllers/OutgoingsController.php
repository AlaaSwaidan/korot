<?php

namespace Modules\Accounts\Http\Controllers;

use App\Models\Bank;
use App\Models\Outgoing;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Accounts\Http\Requests\OutgoingRequest;
use Modules\Accounts\Repositories\OutgoingsRepository;

class OutgoingsController extends Controller
{
    public $repository ;

    public function __construct()
    {
        $this->middleware('permission:view_outgoings');
        $this->middleware('permission:create_outgoings', ['only' => ['store','create']]);
        $this->middleware('permission:update_outgoings', ['only' => ['edit','update']]);
        $this->middleware('permission:destroy_outgoings', ['only' => ['destroy_selected_rows','destroy']]);
        $this->middleware('permission:show_outgoings', ['only' => ['show']]);
        $this->middleware('permission:accept_outgoings', ['only' => ['confirm_page','confirm']]);

        $this->repository = new OutgoingsRepository();
    }

    public function index()
    {
        $data = $this->repository->index();
        return view('accounts::outgoings.index',compact('data'));
    }
    public function show(Outgoing $outgoing)
    {
        return view('accounts::outgoings.show', compact('outgoing'));
    }

    public function all_banks()
    {
        $outgoings = Bank::where('type','bank')->Order()->get();
        $outgoings->map(function ($q){
            $q['name_ar']=$q->name['ar'];
            return $q;
        });
        $data['banks']= $outgoings;
        return json_encode($data);
    }

    public function all_stores()
    {
        $outgoings = Bank::where('type','cash')->Order()->get();
        $outgoings->map(function ($q){
            $q['name_ar']=$q->name['ar'];
            return $q;
        });
        $data['banks']= $outgoings;
        return json_encode($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('accounts::outgoings.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(OutgoingRequest $request)
    {
        $data = $this->repository->store($request);
        return $data ?
            redirect()->route('admin.outgoings.index')->with('success', trans('messages.addOK')) :
            redirect()->route('admin.outgoings.index')->with('warning', trans('messages.addNO'));
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
    public function edit(Outgoing $outgoing)
    {
        $type = $outgoing->payment_method == "cash" ? "cash" : "bank";
        $banks = Bank::where('type',$type)->get();
        return view('accounts::outgoings.edit',compact('outgoing','banks'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(OutgoingRequest $request, Outgoing $outgoing)
    {
        $updated = $this->repository->update($request, $outgoing);
        return $updated ?
            redirect()->route('admin.outgoings.index')->with('success', trans('messages.updateOK')) :
            redirect()->route('admin.outgoings.index')->with('warning', trans('messages.updateNO'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */

    public function confirm_page(Outgoing $outgoing)
    {
        $type = $outgoing->payment_method == "cash" ? "cash" : "bank";
        $banks = Bank::where('type',$type)->get();
        return view('accounts::outgoings.confirm',compact('outgoing','banks'));
    }


    public function confirm(OutgoingRequest $request,Outgoing $outgoing)
    {
        $data = $this->repository->confirm($request, $outgoing);

        return $data ?
            redirect()->route('admin.outgoings.index')->with('success', trans('messages.updateOK')) :
            redirect()->route('admin.outgoings.index')->with('warning', trans('messages.updateNO'));
    }

    public function destroy(Request $request)
    {
        $deleted = $this->repository->destroy($request);
        $url = route('admin.outgoings.index');

        return $deleted
            ? json_encode(['code' => '1', 'url' => $url])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
    public function destroy_selected_rows(Request $request)
    {
        $deleted = $this->repository->destroy_selected_rows($request);
        $url = route('admin.outgoings.index');

        return $deleted
            ? json_encode(['code' => '1', 'url' => $url])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
}
