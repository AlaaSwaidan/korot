<?php

namespace Modules\Accounts\Http\Controllers;

use App\Models\Bank;
use App\Models\Journal;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Accounts\Repositories\JournalsRepository;
use Modules\Transfers\Entities\Transfer;

class JournalsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public $repository;
    public function __construct()
    {
        $this->middleware('permission:view_journals');

        $this->repository = new JournalsRepository();
    }
    public function index()
    {
        return view('accounts::journals.index');
    }
    public function search(Request $request)
    {

        $from_date =$request->from_date;
        $to_date =$request->to_date;
        $today = "";
        $data = Journal::Order();
        $new_data = clone $data;
        if ($request->from_date && $request->to_date){
            $startDate = Carbon::parse($request->from_date);
            $endDate = Carbon::parse($request->to_date);

            $last_data = $data->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate])->get();

            $data =$data->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate])
                ->get()
                ->groupBy('bank_id');

//            foreach($data as $key => $value){
//                dd($value);
//            }
//            dd($data);


            $today =' التاريخ '.$startDate->format('Y-m-d').' الى '.$endDate->format('Y-m-d');
        }

        $banks = Bank::get();
        return view('accounts::journals.index',compact('data', 'from_date','to_date','today','banks','last_data'));
    }
    public function generate_pdf($journal)
    {
        $str = ltrim($journal, 'S');
        $transfer = Transfer::find($str);
        $type =getUserTypeModel($transfer->userable_type);

        $pdf = $this->repository->generate_pdf($transfer,$type);
        return $pdf;

    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('accounts::create');
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
        return view('accounts::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('accounts::edit');
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
