<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Http\Requests\AdminRequest;
use Modules\Admin\Repositories\AdminRepository;
use Modules\Admin\Repositories\RepaymentRepository;
use Modules\Collections\Repositories\CollectionRepository;
use Modules\Transfers\Entities\Transfer;
use Modules\Transfers\Repositories\TransferRepository;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public $repository;

    public function __construct()
    {
        $this->middleware('permission:view_admins');
        $this->middleware('permission:create_admins', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_admins', ['only' => ['edit','updateAdminPassword','showChangePasswordForm', 'update']]);
        $this->middleware('permission:delete_admins', ['only' => ['destroy','destroy_selected_rows']]);

        $this->repository = new AdminRepository();
        $this->repositoryTransfers = new TransferRepository();
        $this->repositoryCollections = new CollectionRepository();
        $this->repositoryRepayment = new RepaymentRepository();
    }

    public function index()
    {
        $data = $this->repository->index();
        return view('admin::admins.index', compact('data'));

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $roles = Role::where('id','!=',1)->get();
        return view('admin::admins.create',compact('roles'));

    }


    public function store(AdminRequest $request)
    {
        $data = $this->repository->store($request);

        return $data ?
            redirect()->route('admin.admins.index')->with('success', trans('messages.addOK')) :
            redirect()->route('admin.admins.index')->with('warning', trans('messages.addNO'));

    }


    public function show(Admin $admin)
    {

        return view('admin::admins.show', compact('admin'));
    }

    public function transfers(Admin $admin)
    {
        $data = $this->repositoryTransfers->index($admin);
        return view('admin::admins.transfers',compact('admin','data'));
    }
    public function collections(Admin $admin)
    {
        $data = $this->repositoryCollections->index($admin);
        return view('admin::admins.collections',compact('admin','data'));
    }
    public function collections_from_dis(Admin $admin)
    {
        $data = $admin->providerable()->where('type','collection')->Order()->paginate(20)->appends(request()->except('page'));
        return view('admin::admins.collections_from_dis',compact('admin','data'));
    }
    public function transfers_to_dis(Admin $admin)
    {
        $data = $admin->providerable()->where('type','transfer')->Order()->paginate(20)->appends(request()->except('page'));
        return view('admin::admins.transfers_to_dis',compact('admin','data'));
    }
    public function repayments(Admin $admin)
    {
        //repayment
        $data = $this->repositoryRepayment->index($admin);
        return view('admin::admins.repayments',compact('admin','data'));
    }

    public function processes(Admin $admin)
    {
        $data =Transfer::where(function ($q) use($admin){
            $q->where(function ($q1)use($admin){
                $q1->where('providerable_type','App\Models\Admin')->where('providerable_id',$admin->id);
            });
            $q->orWhere(function ($q2)use($admin){
                $q2->where('userable_type','App\Models\Admin')->where('userable_id',$admin->id);
            });
        })->Order()->paginate(20)->appends(request()->except('page'));
        return view('admin::admins.processes',compact('admin','data'));
    }
    public function accounts(Request $request,Admin $admin)
    {
        $data =Transfer::where(function ($q) use($admin){
            $q->where(function ($q1)use($admin){
                $q1->where('providerable_type','App\Models\Admin')->where('providerable_id',$admin->id);
            });
            $q->orWhere(function ($q2)use($admin){
                $q2->where('userable_type','App\Models\Admin')->where('userable_id',$admin->id);
            });
        })->Order();
        $new_data = clone $data;
        $startDate = $request->from_date;
        $endDate = $request->to_date;
        $time =$request->time ? $request->time : 'today';
        if ($time == "today") {
            $last_data = $data->whereDate('created_at', Carbon::now())->get();
            $first_data = $new_data->whereDate('created_at', '<', Carbon::now())->first();
            $today = ' التاريخ '.Carbon::now()->format('Y-m-d');
        }

        if ($time == "exact_time"){
            $startDate = Carbon::parse($request->from_date);
            $endDate = Carbon::parse($request->to_date);

            $last_data = $data->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate])->get();
            $data =$data->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate])
                ->get()
                ->groupBy([
                    function ($val) { return $val->created_at->format('m'); },
                    function ($val) { return $val->created_at->format('d'); }
                ]);

//            foreach($data as $key => $value){
//                dd($value);
//            }
//            dd($data);


            $first_data = $new_data->whereDate('created_at', '<', $startDate)->first();
            $today =' التاريخ '.$startDate->format('Y-m-d').' الى '.$endDate->format('Y-m-d');
        }

//        $data =$data->paginate(20)->appends(request()->except('page'));
        return view('admin::admins.accounts',compact('admin','last_data','data','first_data','today','time','startDate','endDate'));
    }
    public function edit(Admin $admin)
    {
        $roles = Role::where('id','!=',1)->get();
        return view('admin::admins.edit', compact('admin','roles'));

    }

    public function update(AdminRequest $request, Admin $admin)
    {
        $updated = $this->repository->update($request, $admin);
        return $updated ?
            redirect()->route('admin.admins.index')->with('success', trans('messages.updateOK')) :
            redirect()->route('admin.admins.index')->with('warning', trans('messages.updateNO'));
    }


    public function destroy(Request $request)
    {


        $deleted = $this->repository->destroy($request);

        $url = route('admin.admins.index');
        return $deleted
            ? json_encode(['code' => '1', 'url' => $url])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }
    public function destroy_selected_rows(Request $request)
    {


        $deleted = $this->repository->destroy_selected_rows($request);

        $url = route('admin.admins.index');
        return $deleted
            ? json_encode(['code' => '1', 'url' => $url])
            : json_encode(['code' => '0', 'message' => 'نأسف لحدوث هذا الخطأ, برجاء المحاولة لاحقًا']);
    }

    public function showChangePasswordForm(Admin $admin)
    {
        return view('admin::admins.change_password', compact('admin'));

    }

    public function updateAdminPassword(Request $request, Admin $admin)
    {

        $request->validate([
            'new_password' => 'required|min:3|max:191',
            'password_confirm' => 'same:new_password',
        ]);

     $updated =    $this->repository->update_password($request,$admin);
        return $updated ?
            redirect()->route('admin.admins.index')->with('success', 'تم تغيير كلمة مرور مشرف بنجاح') :
            redirect()->route('admin.admins.index')->with('warning', 'حدث خطأ ما, برجاء المحاولة مرة اخرى');
    }
}
