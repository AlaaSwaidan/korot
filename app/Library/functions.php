<?php


use App\Models\Merchant;
use App\Models\Admin;
use App\Models\Distributor;
use App\Models\Order;
use Modules\Transfers\Entities\Transfer;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Salla\ZATCA\GenerateQrCode;
use Salla\ZATCA\Tags\InvoiceDate;
use Salla\ZATCA\Tags\InvoiceTaxAmount;
use Salla\ZATCA\Tags\InvoiceTotalAmount;
use Salla\ZATCA\Tags\Seller;
use Salla\ZATCA\Tags\TaxNumber;

//use FCM;

//2XgEKu3X$kTE?4-
//*&0#MV#{z2eg

/*to get error in nice format*/
function explodeByUnderscore( $str ) {
    return explode( "_", $str );
}
function getExplodeByUnderscore( $str ) {
    return substr($str, strpos($str, "_") + 1);
}

function getTransfer($order)
{
    $transfer = Transfer::whereOrderId($order->id)->first();
    return $transfer;
}
function getTransfers($orders)
{
    $transfer = Transfer::whereIn('order_id',$orders)->sum('geidea_commission');
    return $transfer;
}
function Handle403($message){
    return response()->json([
        'mainCode' => 0,
        'code' => '403',
        'error' => [$message]
    ], 403);
}
function getOrder($card){
    return Order::where('card_number',$card->card_number)->where('serial_number',$card->serial_number)->where('paid_order','paid')->first();
}
function getTransactionId($card_number,$serial_number){
    $transaction= Order::where('card_number',$card_number)->where('serial_number',$serial_number)->first()->transaction_id;
    return  $transaction ?? 'لا يوجد';
}
function getFormattedException($e): string
{
    return $e->getMessage() .' in '. $e->getFile() .' at line '. $e->getLine();
}
function siteLanguages()
{
    return [
        'ar' => 'عربي',
        'en' => 'English',
    ];
}
function cardsType()
{

         return [
             'golden' => 'الذهبي',
             'silver' => 'الفضي',
             'bronze' => 'النحاسي',
             'platinum' => 'بلاتيني',
             'bronzz' => 'برونزي',
             'diamond' => 'ماسي',
             'pearl' => 'لؤلؤي',
             'emerald' => 'زمردي',
             'ruby' => 'ياقوتي',
             'crystal' => 'كريستالي',
         ];

}

function added_by_type($type,$value){
    switch ($type) {
        case 'admin':
            return ' ادمن : '.$value->admin->name;
        case 'site':
            return "الموقع";
        case 'added_by_type':
            return "التطبيق";
        case 'distributor':
            return ' موزع : '.$value->distributor->name;
        default:
            return null;
    }
}
function collectionType($type){
    switch ($type) {
        case 'cash':
            return 'نقدي';
        case 'bank':
            return "بنك";
        case 'check':
            return 'شيك';
        default:
            return null;
    }
}
function MerchantType($type){
    switch ($type) {
        case 'golden':
            return 'ذهبي';
        case 'silver':
            return "فضي";
        case 'bronze':
            return 'نحاسي';
        default:
            return null;
    }
}
function SupplireType($type){
    switch ($type) {
        case 'company':
            return 'شركة';
        case 'individual':
            return "فرد";
        default:
            return null;
    }
}
function bankName($type){
    switch ($type) {
        case 'ahly':
            return 'الأهلي';
        case 'raghy':
            return "الراجحي";
        case 'enmaa':
            return 'الإنماء';
        case 'ryad':
            return 'الرياض';
        default:
            return null;
    }
}
function getClassModel($type){
    switch ($type) {
        case 'merchants':
            return 'App\Models\Merchant';
        case 'admins':
            return "App\Models\Admin";
        case 'distributors':
            return 'App\Models\Distributor';
        case 'users':
            return 'App\Models\User';
        default:
            return null;
    }
}
function getUserModel($type,$id){
    switch ($type) {
        case 'App\Models\Merchant':
            return Merchant::find($id);
        case 'App\Models\Admin':
            return Admin::find($id);
        case 'App\Models\Distributor':
            return Distributor::find($id);
        default:
            return null;
    }
}
function getUserTypeModel($type){
    switch ($type) {
        case 'App\Models\Merchant':
            return "merchant";
        case 'App\Models\Admin':
            return "admins";
        case 'App\Models\Distributor':
            return "distributors";
        default:
            return null;
    }
}
function getUserTypeModelName($type){
    switch ($type) {
        case 'App\Models\Merchant':
            return "تاجر";
        case 'App\Models\Admin':
            return "مدير";
        case 'App\Models\Distributor':
            return "موزع";
        default:
            return null;
    }
}
function getProcessType($type){
    switch ($type) {
        case 'collection':
            return 'تحصيل';
        case 'transfer':
            return "تحويل";
        case 'indebtedness':
            return 'مديونية';
        case 'repayment':
            return 'تعويض';
        case 'profits':
            return 'تحويل ارباح';
        case 'payment':
            return 'دفع مديونية';
        case 'recharge':
            return 'شحن';
        case 'sales':
            return 'مبيعات';
        case 'restore':
            return 'استرجاع بطاقة';
        default:
            return null;
    }
}
function getDayBefore($merchant,$startDate,$endDate,$value){
   $balance = $merchant->userable()->Order()->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate])
    ->whereDate('created_at','<',$value->first()->created_at->format('Y-m-d'))->first();
   $result = $balance ? $balance->balance_total : 0;
     return $result;
}
function getMonth($number){
    switch ($number) {
        case '12':
            return 'ديسمبر';
        case '11':
            return "نوفمبر";
        case '10':
            return 'اكتوبر';
        case '09':
            return 'سبتمبر';
        case '08':
            return 'أغسطس';
        case '07':
            return 'يوليو';
        case '06':
            return 'يونيو';
        case '05':
            return 'مايو';
        case '04':
            return 'إبريل';
        case '03':
            return 'مارس';
        case '02':
            return 'فبراير';
        case '01':
            return 'يناير';
        default:
            return null;
    }
}

function getAddedBy($type,$transfer){
    switch ($type) {
        case 'repayment':
            return trans('api.repayment');
        case 'profits':
            return trans('api.profits');
        case 'payment':
            return trans('api.payment');
        case 'recharge':
            return trans('api.recharge');
        case 'sales':
            return trans('api.sales');
        case 'restore':
            return trans('api.restore_sold_card');
        default:
            return $transfer->fromAdmin->name;
    }
}
function getPayType($type){
    switch ($type) {
        case 'bank_transfer':
            return trans('api.bank_transfer');
        case 'balance':
            return trans('api.balance');
        case 'online':
            return trans('api.online');
        default:
            return null;
    }
}

function getName($type){
    switch ($type) {
        case 'merchants':
            return 'التجار';
        case 'admins':
            return "المدراء";
        case 'distributors':
            return 'الموزعين';
        default:
            return null;
    }
}
function getRepo($type,$array){
    switch ($type) {
        case 'merchants':
            return $array[0]->index();
        case 'admins':
            return $array[2]->index();
        case 'distributors':
            return $array[1]->index();
        default:
            return null;
    }
}
function NotApprovedMerchants(){
    return Merchant::Order()->where('approve',0)->count();
}
function ordersWaitingToApprove(){
    return Transfer::where('pay_type','bank_transfer')->where('confirm',0)->count();
}

function updateTransfer($data,$user){
   $transfer = Transfer::find($data->id);

   $updated = $transfer->update([
        'balance_total'=>$transfer->balance_total ? $transfer->balance_total : $user->balance,
        'repayment_total'=>$transfer->repayment_total ? $transfer->repayment_total : $user->repayment_total,
        'profits_total'=>$transfer->profits_total ? $transfer->profits_total : $user->profits,
        'transfers_total'=>$transfer->transfers_total ? $transfer->transfers_total : $user->transfer_total,
        'collection_total'=>$transfer->collection_total ? $transfer->collection_total : $user->collection_total,
        'indebtedness'=>$transfer->indebtedness ? $transfer->indebtedness : $user->indebtedness,
    ]);

   return $transfer;

}
function settings() {

    return \App\Models\Setting::where( 'id', 1 )->first();
}



function ProductRatingsStars($rate)
{
    $str = '';
    for ($i = 0; $i < 5; $i++) {
        if ($rate >= $i+1)
            $str .= '<i class="fa fa-star" style="color: #f0c411;"></i>';
        else
            $str .= '<i class="fa fa-star" style="color: #d8d6cf;"></i>';
    }
    return $str;
}


function validateRules($errors, $rules) {

    $error_arr = "";
    foreach ($rules as $key => $value) {
        if( $errors->get($key) ) {
            $error_arr .= $errors->first($key);
        }
        break;
    }

    return $error_arr;
}
function validateRulesAdmin($errors, $rules) {

    $error_arr = [];

    foreach ($rules as $key => $value) {

        if( $errors->get($key) ) {

            array_push($error_arr, array('key' => $key, 'value' => $errors->first($key)));
        }
    }

    return $error_arr;
}
function randNumber($length) {

    $seed = str_split('0123456789');

    shuffle($seed);

    $rand = '';

    foreach (array_rand($seed, $length) as $k) $rand .= $seed[$k];

    return $rand;
}

function generateApiToken($userId) {

    $myTTL = 60 * 60 * 365; //minutes
    JWTAuth::factory()->setTTL($myTTL);
    $token = JWTAuth::fromUser($userId);

    return $token;
}

function UploadBase64Image($base64Str, $prefix, $folderName) {

    $image = base64_decode($base64Str);
    $image_name = $prefix . '_' . time() .'.png';
    $path = public_path( 'uploads' ) . DIRECTORY_SEPARATOR . $folderName . DIRECTORY_SEPARATOR . $image_name;

    $saved = file_put_contents($path, $image);

    return $saved ? $image_name : NULL;
}

function UploadImage( $inputRequest, $prefix, $folderNam ) {

    $imageName = $prefix . '_' . time().randNumber(4) .'.' . $inputRequest->getClientOriginalExtension();

    $destinationPath = public_path( '/' . $folderNam );

    $inputRequest->move( $destinationPath, $imageName );

    return $imageName ? $imageName : false;
}
function UploadImageEdit( $inputRequest, $prefix, $folderNam, $oldImage ) {
    @unlink(public_path('/'.$folderNam.'/'.$oldImage));
    $imageName = $prefix . '_' . time().randNumber(4) .'.' . $inputRequest->getClientOriginalExtension();

    $destinationPath = public_path( '/' . $folderNam );

    $inputRequest->move( $destinationPath, $imageName );

    return $imageName ? $imageName : false;
}
function UploadImageSize( $inputRequest, $prefix, $folderNam , $width , $height ) {

    $imageName =  $prefix . '_' . time().randNumber(5).'.' . $inputRequest->getClientOriginalExtension();

    $destinationPath = public_path( '/' . $folderNam );
    $img = Image::make($inputRequest->getRealPath());
    $img->resize($width, $height)->save($destinationPath.'/'.$imageName);

    return $imageName ? $imageName : false;


}





function checkPermissionExists($id, $permissionsIds) {

    return in_array($id, $permissionsIds);
}

function userRatingsStars($rate)
{
    $str = '';
    for ($i = 0; $i < 5; $i++) {
        if ($rate >= $i+1)
            $str .= '<i class="fa fa-star" style="color: #f0c411;"></i>';
        else
            $str .= '<i class="fa fa-star" style="color: #d8d6cf;"></i>';
    }
    return $str;
}



function HandleSMSResponse($response){
    return "code status is : ".$response->getCode()." error message : ". $response->getMessage();
}
function generateQrCode( $orders) {
    $total = $orders->sum('all_cost');
    $generatedString = GenerateQrCode::fromArray([
        new Seller(settings()->name['ar']), // seller name
        new TaxNumber(300453343300003), // seller tax number
        new InvoiceDate(Carbon::now()->toISOString()), // invoice date as Zulu ISO8601 @see https://en.wikipedia.org/wiki/ISO_8601
        new InvoiceTotalAmount(number_format($total,2,".","")), // invoice total amount
        new InvoiceTaxAmount(number_format(0,2,".","")) // invoice tax amount
        // TODO :: Support others tags
    ])->toBase64();
//    return $displayQRCodeAsBase64;

    /* qr code generate */
    $name = time().randNumber(4);
    QrCode::size(500)
//            ->color(8, 154, 175)
//            ->backgroundColor(255, 255, 255)
        ->style('round')
        ->generate($generatedString, public_path('uploads/qr-code-images/'.$name.'.svg'));

    $image =$name.'.svg';


    return $image;
}
