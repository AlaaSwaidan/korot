<!DOCTYPE html>
<html direction="rtl" dir="rtl" style="direction: rtl">
<head>
    <meta charset="utf-8" />
    <title>لوحة التحكم | بيانات كشف الحساب</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="og:title" content="{{trans('web.meta_title')}}" />
    <meta content="{{trans('web.meta_description')}}" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">

    <style>
        * {
            /*font-family: 'dejavu sans', sans-serif;*/
            margin:0;padding:0;border:0;
            font-family: 'Cairo';
            font-weight: bolder;
            font-size: 10px;
            direction:rtl;
            text-alignment:right;
        }


    </style>
</head>

<!-- END HEAD -->

<body style="margin:0;padding:0;border:0;">
<div style="text-align:center;">
    <img src="{{ public_path('/admin/logo/logo.png') }}" style="width: 200px;height: 150px;"  >
</div>

<br/>

<table style="width:100%;border:none;">
    <tr>
        <td style="text-align:right;">
            مرحبا, {{ $user->name }}
        </td>
    </tr>
</table>

<div style="clear:both;"></div>
<table style="width:100%;border:1px solid #dee2e6;">
    <thead>
    <tr>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">#</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">النوع</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">رقم العملية	</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">المبلغ	</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">التحويلات	</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">التحصيلات</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">المديونية</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">التعويضات</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">الربح</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">مجموع الأرباح	</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">الرصيد	</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">التاريخ	</th>
{{--        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">الرصيد</th>--}}


    </tr>
    </thead>
    <tbody>
    <?php
        $i=1;
        ?>
    @foreach($data as $value)
        <?php
            $get_data = \Modules\Transfers\Entities\Transfer::where('userable_type',getClassModel($type))->Order();

            if (isset($get_data)){
                $transfers = clone $get_data;
                $collections = clone $get_data;
                $repayment = clone $get_data;
                $indebtedness = clone $get_data;
                $indebtedness1 = clone $get_data;
                $profits = clone $get_data;
                $profits1 = clone $get_data;
            }

            if (isset($time) && $time == "today") {
                $transfers = $transfers->where('type','transfer')->whereDate('created_at', \Carbon\Carbon::now())->sum('amount');
                $collections = $collections->where('type','collection')->whereDate('created_at', \Carbon\Carbon::now())->sum('amount');
                $repayment = $repayment->where('type','repayment')->whereDate('created_at', \Carbon\Carbon::now())->sum('amount');
                $indebtedness = $indebtedness->where('type','indebtedness')->whereDate('created_at', \Carbon\Carbon::now())->sum('amount')+
                    $indebtedness1->where('type','payment')->whereDate('created_at', \Carbon\Carbon::now())->sum('amount') ;
                $profits = $profits->where('type','profits')->whereDate('created_at', \Carbon\Carbon::now())->sum('amount')+
                    $profits1->where('type','sales')->whereDate('created_at', \Carbon\Carbon::now())->sum('profits') ;
            }elseif (isset($time) && $time == "exact_time"){
                $startDate =\Carbon\Carbon::parse($from_date);
                $transfers = $transfers->where('type','transfer')->whereBetween('created_at', [$startDate, $value->created_at])->sum('amount');
                $collections = $collections->where('type','collection')->whereBetween('created_at', [$startDate, $value->created_at])->sum('amount');
                $repayment = $repayment->where('type','repayment')->whereBetween('created_at', [$startDate, $value->created_at])->sum('amount');
                $indebtedness = $indebtedness->where('type','indebtedness')->whereBetween('created_at', [$startDate, $value->created_at])->sum('amount')+
                    $indebtedness1->where('type','payment')->whereBetween('created_at', [$startDate, $value->created_at])->sum('amount');
                $profits = $profits->where('type','profits')->whereBetween('created_at', [$startDate, $value->created_at])->sum('amount')+
                    $profits1->where('type','sales')->whereBetween('created_at', [$startDate, $value->created_at])->sum('profits');
            }else{
                $transfers =$value->type == "transfer"?  ($value->transfers_total ?? 0) : '';
                $collections =$value->type == "collection"?  ($value->collection_total ?? 0) : '';
                $repayment =$value->type == "repayment"?  ($value->repayment_total ?? 0) : '';
                $indebtedness =$value->type == "indebtedness" || $value->type == "payment" ? ($value->indebtedness ?? 0) : '';
                $profits =$value->type == "profits" || $value->type == "sales"  ? $value->profits_total : '';
            }
            ?>
        <tr>
            <td style="border:1px solid #dee2e6;text-align:center;">{{ $i++ }}</td>
            <td style="border:1px solid #dee2e6;">
                {{ getProcessType($value->type) }} -
                {{ $value->type == "sales"  ? ($value->order->payment_method == "wallet" ? 'محفظة' : 'جيديا') :''  }}

            </td>
            <td style="border:1px solid #dee2e6;text-align:center;">{{ $value->type == "recharge"  ? $value->transaction_id : '---'}}</td>
            <td style="border:1px solid #dee2e6;text-align:center;">{{ $value->amount }}</td>
            <td style="border:1px solid #dee2e6;text-align:center;">{{ $value->type == "transfer"?  $transfers : '' }}</td>
{{--            <td style="border:1px solid #dee2e6;text-align:center;">{{ number_format($order->cost,2) }}</td>--}}
            <td style="border:1px solid #dee2e6;text-align:center;">{{ $value->type == "collection"? $collections : '' }}</td>
            <td style="border:1px solid #dee2e6;text-align:center;">{{ $value->type == "indebtedness" || $value->type == "payment" ? $indebtedness : '' }}</td>
            <td style="border:1px solid #dee2e6;text-align:center;">{{ $value->type == "repayment"? $repayment : '' }}</td>
            <td style="border:1px solid #dee2e6;text-align:center;">{{ $value->type == "profits" || $value->type == "sales"  ? $value->profits : ''}}</td>
            <td style="border:1px solid #dee2e6;text-align:center;">{{ $value->type == "profits" || $value->type == "sales"  ?  $profits : '' }}</td>
            <td style="border:1px solid #dee2e6;text-align:center;">{{ $value->balance_total}}</td>
            <td style="border:1px solid #dee2e6;text-align:center;">{{ $value->created_at->format('Y-m-d g:i A') }}</td>
{{--            <td style="border:1px solid #dee2e6;text-align:center;">{{  number_format(\Modules\Transfers\Entities\Transfer::whereOrderId($order->parent_id)->latest('created_at')->first()->balance_total,2) }} </td>--}}

       </tr>
    @endforeach


    </tbody>
</table>
</body>
</html>

