<?php

namespace Modules\SendNotification\Repositories;




use App\Models\Distributor;
use App\Models\Merchant;
use App\Models\UserDevice;

class NotificationRepository
{


    public function index($type)
    {
        if ($type == "merchants"){
            $data = Merchant::Order()->where('approve',1)->get();
        } elseif ($type == "distributors"){
            $data = Distributor::Order()->get();
        }

        return $data;
    }


    public function send_notifications($request)
    {

        try {
            $request->validate([
                'user.*'      => 'required',
                'message'   => 'required|array',
                'title'   => 'required|array',
                'message.*'   => 'required',
                'title.*'   => 'required',
            ]);

            $notificationTitle = array(
                'ar'=>$request->title['ar'],
                'en'=>$request->title['en'],
            );
            $notificationMessage = array(
                'ar'=>$request->message['ar'],
                'en'=>$request->message['en'],

            );
            $all_data_ar = array(
                'title'=>$request->title['ar'],
                'body'=>$request->message['ar'],
                'type'=>1,
                'seen'=>0,
                'notifiable_id'=>null,
                'sound' => 'default',
//                'click_action' => 'FCM_PLUGIN_ACTIVITY',
            );

            $all_data_en = array(
                'title'=>$request->title['en'],
                'body'=>$request->message['en'],
                'type'=>1,
                'seen'=>0,
                'notifiable_id'=>null,
                'sound' => 'default',
//                'click_action' => 'FCM_PLUGIN_ACTIVITY',
            );
            if($request->type == 'distributors') {
                foreach ($request->user as $user){
                    if($user == 'distributors') {
                        $usersIds       = Distributor::get()->pluck('id')->toArray();
                        foreach ($usersIds as $id)
                            saveNotification(1, serialize($notificationTitle) , serialize($notificationMessage),$id,getClassModel($request->type));


                        sendTopicNotification($all_data_ar,'distributors_ar');
                        sendTopicNotification($all_data_en,'distributors_en');

                        return 'send_success';
                    }
                    else {
                        $all_data = array(
                            'title'=>$notificationTitle['ar'],
                            'body'=>$notificationMessage['ar'],
                            'type'=>1,
                            'seen'=>0,
                            'notifiable_id'=>null,
                            'sound' => 'default',
//                    'click_action' => 'FCM_PLUGIN_ACTIVITY',
                        );
                        saveNotification(1, serialize($notificationTitle) , serialize($notificationMessage),$user,getClassModel($request->type));

                        $devicesTokens  = UserDevice::where('userable_id', $user)
                            ->where('userable_type',getClassModel($request->type))
                            ->where('is_open', true)
                            ->orderBy('updated_at', 'DESC')
                            ->pluck('firebase_token')
                            ->toArray();
                    }
                    if($devicesTokens)
                        sendMultiNotification($all_data, $devicesTokens);


                }
                return 'send_success';
            }
            elseif($request->type == 'merchants') {
                foreach ($request->user as $user){
                    if($user == 'merchants') {
                        $usersIds       = Merchant::Order()->where('approve',1)->get()->pluck('id')->toArray();
                        foreach ($usersIds as $id)
                            saveNotification(1, serialize($notificationTitle) , serialize($notificationMessage),$id,getClassModel($request->type));


                        sendTopicNotification($all_data_ar,'merchants_ar');
                        sendTopicNotification($all_data_en,'merchants_en');

                        return 'send_success';
                    }
                    else {
                        $all_data = array(
                            'title'=>$notificationTitle['ar'],
                            'body'=>$notificationMessage['ar'],
                            'type'=>1,
                            'seen'=>0,
                            'notifiable_id'=>null,
                            'sound' => 'default',
//                    'click_action' => 'FCM_PLUGIN_ACTIVITY',
                        );
                        saveNotification(1, serialize($notificationTitle) , serialize($notificationMessage),$user,getClassModel($request->type));

                        $devicesTokens  = UserDevice::where('userable_id', $user)
                            ->where('userable_type',getClassModel($request->type))
                            ->where('is_open', true)
                            ->orderBy('updated_at', 'DESC')
                            ->pluck('firebase_token')
                            ->toArray();
                    }
                    if($devicesTokens)
                        sendMultiNotification($all_data, $devicesTokens);


                }
                return 'send_success';
            }
            abort('404');
        } catch (\Exception $exception) {
            return redirect()->route('admin.notifications.index','type='.$request->type)->with('warning', 'Error , contact system');
        }
    }


}
