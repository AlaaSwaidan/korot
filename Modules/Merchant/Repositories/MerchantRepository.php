<?php

namespace Modules\Merchant\Repositories;

use App\Models\Merchant;
use App\Models\UserToken;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Transfers\Entities\Transfer;
use PDF;
use Tymon\JWTAuth\Facades\JWTAuth;

class MerchantRepository
{

    public function index()
    {
        $data = Merchant::Order()->where('approve',1)->where('id','!=',632)->paginate(20)->appends(request()->except('page'));
        // Add the `is_inactive` flag after pagination
$data->getCollection()->transform(function ($data) {
    $data->is_inactive = $data->last_login_at === null ||
        Carbon::parse($data->last_login_at)->lt(now()->subDays(7));
    return $data;
});
        return $data;
    }
    public function orders($merchant)
    {
        $data = $merchant->orders()->where('paid_order',"paid")->where('parent_id','!=',null)->orderBy('id','desc')->paginate(20)->appends(request()->except('page'));
        return $data;
    }
    public function store($request)
    {
        try {

            $request['active'] = isset($request->status) ? $request->status : 0;
            $request['mada_pay'] = isset($request->mada_pay) ? $request->mada_pay : 0;

            $request['added_by']=auth()->guard('admin')->user()->id;
            $request['added_by_type']="admin";
            if ( isset($request->photo) && $request->photo ){
                $request['image'] = UploadImage($request->file('photo'), 'merchants', '/uploads/merchants');

            }

            $request['approve']=1;
            $merchant = Merchant::create($request->all());
            return $merchant;
        } catch (\Exception $exception) {
            return redirect()->route('admin.merchants.index')->with('warning', 'Error , contact system');
        }
    }

    public function update($request, $merchant)

    {
        try {
            if ( isset($request->photo) && $request->photo ){
                @unlink(public_path('uploads/merchants/') . $merchant->image);
                $request['image'] = UploadImage($request->file('photo'), 'merchants', '/uploads/merchants');
            }
            $request['active'] = isset($request->status) ? $request->status : 0;
            $request['mada_pay'] = isset($request->mada_pay) ? $request->mada_pay : 0;
            $updated = $merchant->update($request->all());
            return $updated;
        } catch (\Exception $exception) {
            return redirect()->route('admin.merchants.index')->with('warning', 'Error , contact system');

        }

    }
    public function update_geidea($request, $merchant)

    {
        try {
            $updated = $merchant->update($request->all());
            return $updated;
        } catch (\Exception $exception) {
            return redirect()->route('admin.merchants.index')->with('warning', 'Error , contact system');

        }

    }

    public function destroy($request)
    {
        try {
            $data = Merchant::find($request->id);
            $data->update([
                'geidea_user_name'=>null,
                'geidea_serial_number'=>null,
                'geidea_pass'=>null,
                'geidea_percentage'=>null,
            ]);
            $deleted = $data->delete();
            return $deleted;
        } catch (\Exception $exception) {
            return redirect()->route('admin.merchants.index')->with('warning', 'Error , contact system');

        }
    }
    public function destroy_token($request)
    {
        try {
            $data = Merchant::find($request->id);
            $get_token = UserToken::where('userable_id', $data->id)
                ->where('userable_type',get_class($data))
                ->orderBy('id', 'desc')
                ->first();
            if($get_token ){
                JWTAuth::manager()->invalidate(new \Tymon\JWTAuth\Token($get_token->access_token), $forceForever = false);
                UserToken::where('userable_id', $data->id)
                    ->where('userable_type',get_class($data))
                    ->delete();
            }
            return $data;
        } catch (\Exception $exception) {
            return redirect()->route('admin.merchants.index')->with('warning', 'Error , contact system');

        }
    }
    public function destroy_selected_rows($request)
    {
        try {
            $data = Merchant::whereIn('id',$request->ids);
            foreach ($data->get() as $value){
                $value->update([
                    'geidea_user_name'=>null,
                    'geidea_serial_number'=>null,
                    'geidea_pass'=>null,
                    'geidea_percentage'=>null,
                ]);
            }
            $deleted = $data->delete();
            return $deleted;
        } catch (\Exception $exception) {
            return redirect()->route('admin.merchants.index')->with('warning', 'Error , contact system');

        }
    }

    public function update_password($request, $merchant)
    {
        try {
            $updated = $merchant->update(['password' => $request->new_password]);
            return $updated;
        } catch (\Exception $exception) {
            return redirect()->route('admin.merchants.index')->with('warning', 'Error , contact system');

        }
    }
    public  function generate_pdf($merchant,$request) {
        $orders  =$merchant->orders()->where('paid_order',"paid")->where('parent_id','!=',null);
        $startDate = Carbon::parse($request->from_date);
        $endDate = Carbon::parse($request->to_date);
        if ($request->from_date && $request->to_date){
            $orders = $orders->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
            $all = $orders->get()->unique('package_id')->map(function ($all_transactions) use ($startDate,$endDate,$merchant){
                $orders =$all_transactions->where('parent_id','!=',null)
                    ->where('paid_order',"paid")
                    ->where('merchant_id',$merchant->id)->where('package_id',$all_transactions->package_id)
                    ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
                $commission = Transfer::whereOrderId($all_transactions->id)->first();
                $merchant_price =$orders->sum('merchant_price');
                $card_price =$orders->sum('card_price');
                $geidea_commission =$commission->geidea_commission;
                $all_cost =$commission->geidea_commission ? $commission->geidea_commission + $merchant_price : $merchant_price;
                $total =$orders->sum('card_price') - $merchant_price  - $geidea_commission;
                $all_transactions['total_count']=$orders->count();
                $all_transactions['merchant_price']=$merchant_price;
                $all_transactions['card_price']=$card_price;
                $all_transactions['profits']=($total);
                $all_transactions['geidea_commission']=($geidea_commission);
                $all_transactions['all_cost']=($all_cost);
                return $all_transactions;
            });

            $all_data=[
                'user'=>$merchant,
                'from_date'=>$request->from_date,
                'to_date'=>$request->to_date,
                'orders'=>$all
            ];

            $html = view('merchant::pdf.sales_reports_pdf')->with($all_data)->render();
            $id = $merchant->id;
            $pdfarr = [
                'title'=>'الفاتورة ',
                'data'=>$html, // render file blade with content html
                'header'=>['show'=>false], // header content
                'footer'=>['show'=>false], // Footer content
                'font'=>'aealarabiya', //  dejavusans, aefurat ,aealarabiya ,times
                'font-size'=>12, // font-size
                'text'=>'', //Write
                'rtl'=>true, //true or false
                'creator'=>'Korot', // creator file - you can remove this key
                'keywords'=>$id , // keywords file - you can remove this key
                'subject'=>'Invoice', // subject file - you can remove this key
                'filename'=>'sales-reports-'.$id.'.pdf', // filename example - invoice.pdf
                'display'=>'download', // stream , download , print
            ];

            return PDF::HTML($pdfarr);
        }


    }
    public  function sales_invoice_print($merchant,$request) {
        $orders  =$merchant->orders()->where('paid_order',"paid")->where('parent_id','!=',null);
        $startDate = Carbon::parse($request->from_date);
        $endDate = Carbon::parse($request->to_date);
        if ($request->from_date && $request->to_date){
            $orders = $orders->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);
            $all = $orders->get()->unique('package_id')->map(function ($all_transactions) use ($startDate,$endDate,$merchant){
                $orders =$all_transactions->where('parent_id','!=',null)
                    ->where('paid_order',"paid")
                    ->where('merchant_id',$merchant->id)->where('package_id',$all_transactions->package_id)
                    ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate]);

                $commission = Transfer::whereOrderId($all_transactions->id)->first();
                // Access the original value of merchant_price before any changes.
                $original_merchant_price = $all_transactions->getOriginal('merchant_price');

                // You can use this original_merchant_price now instead of modified 'merchant_price'
                $single_merchant_price = $original_merchant_price;
                $merchant_price =$orders->sum('merchant_price');
                $card_price =$orders->sum('card_price');
                $geidea_commission =$commission ? $commission->geidea_commission : 0;
                $all_cost =$geidea_commission ? $commission->geidea_commission + $merchant_price : $merchant_price;
                $total =$orders->sum('card_price') - $merchant_price  - $geidea_commission;
                $all_transactions['total_count']=$orders->count();
                $all_transactions['merchant_price']=$merchant_price;
                $all_transactions['single_merchant_price'] = $single_merchant_price;
                $all_transactions['card_price']=$card_price;
                $all_transactions['profits']=($total);
                $all_transactions['geidea_commission']=($geidea_commission);
                $all_transactions['all_cost']=($all_cost);
                return $all_transactions;
            });
            $qrcode= generateQrCode($all);
            $all_data=[
                'user'=>$merchant,
                'from_date'=>$request->from_date,
                'to_date'=>$request->to_date,
                'orders'=>$all,
                'qrcode'=>$qrcode,
            ];



            $html = view('merchant::pdf.sales_invoice_pdf')->with($all_data)->render();
            $id = $merchant->id;
            $pdfarr = [
                'title'=>'الفاتورة ',
                'data'=>$html, // render file blade with content html
                'header'=>['show'=>false], // header content
                'footer'=>['show'=>false], // Footer content
                'font'=>'aealarabiya', //  dejavusans, aefurat ,aealarabiya ,times
                'font-size'=>12, // font-size
                'text'=>'', //Write
                'rtl'=>true, //true or false
                'creator'=>'Korot', // creator file - you can remove this key
                'keywords'=>$id , // keywords file - you can remove this key
                'subject'=>'Invoice', // subject file - you can remove this key
                'filename'=>'sales-reports-'.$id.'.pdf', // filename example - invoice.pdf
                'display'=>'download', // stream , download , print
            ];

            return PDF::HTML($pdfarr);
        }


    }
}
