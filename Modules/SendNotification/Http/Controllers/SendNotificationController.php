<?php

namespace Modules\SendNotification\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SendNotification\Repositories\NotificationRepository;

class SendNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public $repository;
    public function __construct()
    {
        $type =\request()->type;
        if ($type == "merchants"){
            $this->middleware('permission:send_merchant_notifications', ['only' => ['create','store']]);
        }elseif ($type == "distributors"){
            $this->middleware('permission:send_distributors_notifications', ['only' => ['create','store']]);
        }
        $this->repository = new NotificationRepository();
    }
    public function index()
    {
        return view('sendnotification::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        $type = $request->type;
        $data = $this->repository->index($type);

        return view('sendnotification::notifications.create',compact('type','data'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $data = $this->repository->send_notifications($request);
        return $data ?
            redirect()->route('admin.notifications.create','type='.$request->type)->with('success', 'تم الإرسال بنجاح') :
            redirect()->route('admin.notifications.create','type='.$request->type)->with('warning', trans('messages.addNO'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('sendnotification::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('sendnotification::edit');
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
