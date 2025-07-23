<?php
use  \App\Models\UserDevice;
use App\Models\Notification;
function notificationShortcutTypes(){

    return [
        '1' => 'admin',//عند ارسال رسائل دعائية
        '2' => 'paying an indebtedness',//عند دفع مديونية
        '3' => 'charge balance',//عند شحن رصيد من الموزع للتاجر
        '4' => 'transfer profits bank transfer',//عند تحويل الارباح تحويل بنكي
        '5' => 'paying repayment',//عند اضافة تعويض للتاجر
        '6' => 'charge balance from merchant',//عند شحن التاجر الرصيد

    ];
}
function title_notifications($type){

    switch ($type) {
        case 'profits':
            return array(
                'ar'=>'تحويل الأرباح',
                'en'=>'Transfer Profits',
            );
        case 'recharge_transfer':
            return array(
                'ar'=>' شحن رصيد ',
                'en'=>' Recharge balance',

            );
        case 'recharge_online':
            return array(
                'ar'=>' شحن رصيد  ',
                'en'=>' Recharge balance',

            );
        case 'payment_transfer':
            return array(
                'ar'=>' سداد المديونية ',
                'en'=>' Payment of indebtedness',

            );
        case 'repayment':
            return array(
                'ar'=>' اضافة تعويض ',
                'en'=>' Add Repayment',

            );
        default:
            return null;
    }
}

function messages_notifications($type,$amount=null){

    switch ($type) {
        case 'profits':
            return array(
                'ar'=>' تم اضافة رصيد '.$amount.' من الأرباح لرصيدك ',
                'en'=>'The amount of '.$amount.' of the profits has been added to the your balance',

            );
        case 'recharge_transfer':
            return array(
            'ar'=>' تم شحن رصيدك بواسطة تحويل بنكي بمبلغ '.$amount,
            'en'=>'Your balance has been charged by bank transfer in the amount of '.$amount,

        );
        case 'recharge_online':
            return array(
            'ar'=>' تم شحن محفظتك بمبلغ '.$amount,
            'en'=>'Your balance has been charged  in the amount of '.$amount,

        );
        case 'payment_transfer':
            return array(
            'ar'=>' تم سداد مبلغ '.$amount.' من المديونية ',
            'en'=>$amount.' amount of debt has been paid ',

        );
        case 'repayment':
            return array(
            'ar'=>' تم اضافة تعويض بقيمة '.$amount.' لرصيدك ',
            'en'=>'A compensation of '.$amount.' has been added to your balance',

        );
        default:
            return null;
    }
}
function saveNotification( $type, $title, $message,$userId,$userClass, $notifiableId = null, $notifiableType = null)
{

    $created = Notification::create([ 'type'=> $type, 'title'=> $title,
        'message'=> $message,'userable_id'=>$userId,'userable_type'=>$userClass, 'notifiable_id'=> $notifiableId, 'notifiable_type'=> $notifiableType]);
    return $created;
}
function sendMobileNotification($userId ,$userClass, $title, $message ,$type,$dataId) {
    $devicesTokens = UserDevice::where('userable_id', $userId)
         ->where('userable_type',$userClass)
//         ->where('is_open',1)
        ->get()
        ->pluck('firebase_token')
        ->toArray();
    $all_data = array(
        'title'=>$title,
        'body'=>$message,
        'type'=>$type,
        'seen'=>0,
        'notifiable_id'=>$dataId,
        'sound' => 'default',
//         'click_action' => 'FCM_PLUGIN_ACTIVITY',
    );
    if(count($devicesTokens) > 0){
        sendMultiNotification($all_data ,$devicesTokens);
    }


}
function sendMultiNotification($all_data, $devicesTokens) {

    //FCM api URL
    $url = 'https://fcm.googleapis.com/fcm/send';
    //api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
    $server_key = 'AAAAQhPc0Uk:APA91bG6oR7zgX1zeYDmQUdGIGcFHNQGvGWEBYbyJFX8n_xVZ9W1etbOaIqcr5OkR8c5d4q4W-YfPcgr2hXVjzCUlGMU3Zsgkcod2MwzWSb5rokbPLloz6pVZKjjA_XZBkB-s-_lna7_';

    //header with content_type api key
    $headers = array(
        'Content-Type:application/json; charset=utf-8',
        'Authorization:key='.$server_key
    );


    $fields = [
        'registration_ids' => $devicesTokens, //multple token array
//        'to'        => $tokens, //single token
        'notification' => $all_data,
        'data' => $all_data
    ];


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    curl_close($ch);


}



function sendTopicNotification($all_data,$topicType) {

    //FCM api URL
    $url = 'https://fcm.googleapis.com/fcm/send';
    //api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
    $server_key = 'AAAAQhPc0Uk:APA91bG6oR7zgX1zeYDmQUdGIGcFHNQGvGWEBYbyJFX8n_xVZ9W1etbOaIqcr5OkR8c5d4q4W-YfPcgr2hXVjzCUlGMU3Zsgkcod2MwzWSb5rokbPLloz6pVZKjjA_XZBkB-s-_lna7_';

    //header with content_type api key
    $headers = array(
        'Content-Type:application/json; charset=utf-8',
        'Authorization:key='.$server_key
    );


    $fields = [
        'to'  => '/topics/'.$topicType,
        'notification' => $all_data,
        'data' => $all_data
    ];


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    curl_close($ch);
}

function getUserType($type){

    switch ($type) {
        case 'merchants':
            return 'اسم التاجر';
        case 'distributors':
            return  'اسم الموزع';
        case 'users':
            return 'اسم العميل';
        default:
            return null;
    }
}
