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
    <tr>
        <td style="border:1px solid #dee2e6;">
            <span>بيانات العميل</span>
            <br />
            <span><strong>    اسم العميل : {{ $user->name  }} </strong></span>
            <br />
            <span><strong>    رقم العميل : {{ $user->phone  }} </strong></span>
            <br />
            <span><strong>    الرقم الضريبي : {{ $user->tax_number  }} </strong></span>
            <br />
            <span><strong>    السجل التجاري : {{ $user->commercial_number  }} </strong></span>
            <br />


        </td>
        <td style="border:1px solid #dee2e6;">
            <span>بيانات كشف الحساب</span>
            <br />
            <span><strong>    من تاريخ : {{ $from_date }} </strong></span>
            <br />
            <span><strong>    الى تاريخ : {{ $to_date }} </strong></span>
            <br />
        </td>
        <td style="border:1px solid #dee2e6;">
            <span>بيانات المؤسسة</span>
            <br />
            <span><strong>اسم المؤسسة : </strong> مؤسسة بطاقات التجارية</span>
            <br />
            <span><strong>السجل التجاري : </strong>2251032426</span>
            <br />
            <span><strong>الرقم الضريبي : </strong>300453343300003</span>
            <br />
            <span><strong>العنوان : </strong> الهفوف شارع أبوبكر </span>

        </td>

    </tr>


</table>
<div style="clear:both;"></div>
<table style="width:100%;border:1px solid #dee2e6;">
    <thead>
    <tr>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">#</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">اسم البطاقة</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">الكمية</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">المبيعات</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">التكلفة</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">عمولة مدى</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">التكلفة الاجمالية</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">الربح</th>
{{--        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">الرصيد</th>--}}


    </tr>
    </thead>
    <tbody>
    <?php
        $i=1;
        ?>
    @foreach($orders as $order)
        <tr>
            <td style="border:1px solid #dee2e6;text-align:center;">{{ $i++ }}</td>
            <td style="border:1px solid #dee2e6;">{{ $order->company_name[app()->getLocale()].' - '.$order->package->category->name[app()->getLocale()].' - '.$order->name[app()->getLocale()] }}</td>
            <td style="border:1px solid #dee2e6;text-align:center;">{{ $order->total_count }}</td>
            <td style="border:1px solid #dee2e6;text-align:center;">{{ number_format($order->card_price,2) }}</td>
            <td style="border:1px solid #dee2e6;text-align:center;">{{ number_format($order->merchant_price,2) }}</td>
{{--            <td style="border:1px solid #dee2e6;text-align:center;">{{ number_format($order->cost,2) }}</td>--}}
            <td style="border:1px solid #dee2e6;text-align:center;">{{ number_format($order->geidea_commission,2) }}</td>
            <td style="border:1px solid #dee2e6;text-align:center;">{{ number_format($order->all_cost,2) }}</td>
            <td style="border:1px solid #dee2e6;text-align:center;">{{ number_format($order->profits,2) }} </td>
{{--            <td style="border:1px solid #dee2e6;text-align:center;">{{  number_format(\Modules\Transfers\Entities\Transfer::whereOrderId($order->parent_id)->latest('created_at')->first()->balance_total,2) }} </td>--}}

       </tr>
    @endforeach
    <tr>
        <td style="border:1px solid #dee2e6;text-align:center;" >الاجمالي</td>
        <td style="border:1px solid #dee2e6;">  </td>
        <td style="border:1px solid #dee2e6;text-align:center;">
            <span>{{ $orders->sum('total_count') }}</span>
        </td>
        <td style="border:1px solid #dee2e6;text-align:center;">
            <span>{{ number_format($orders->sum('card_price'),2)  }}</span>
        </td>
        <td style="border:1px solid #dee2e6;text-align:center;">
            <span>{{ number_format($orders->sum('merchant_price'),2)  }}</span>
        </td>
        <td style="border:1px solid #dee2e6;text-align:center;">
            <span>{{ number_format($orders->sum('geidea_commission'),2) }}</span>
        </td>
        <td style="border:1px solid #dee2e6;text-align:center;">
            <span>{{ number_format($orders->sum('all_cost'),2) }}</span>
        </td>
        <td style="border:1px solid #dee2e6;text-align:center;">
            <span>{{ number_format($orders->sum('profits'),2) }}</span>
        </td>

    </tr>

    </tbody>
</table>
<div style="clear:both;"></div>

{{--<table style="width:50%;border:1px solid #dee2e6;">--}}
{{--    <tr>--}}
{{--        <td style="border:1px solid #dee2e6;">--}}
{{--            <span>الاجمالي</span>--}}
{{--            <br />--}}
{{--            <span><strong>اجمالي المبيعات : </strong>{{ $orders->sum('merchant_price')}}</span>--}}
{{--            <br />--}}
{{--            <span><strong>اجمالي التكلفة : </strong>{{ $orders->sum('cost')}}</span>--}}
{{--            <br />--}}
{{--            <span><strong>اجمالي الارباح : </strong>{{ $orders->sum('profits')}}</span>--}}
{{--            <br />--}}
{{--            <span><strong>اجمالي الكروت المباعة : </strong>{{ $orders->sum('total_count')}}</span>--}}
{{--            <br />--}}
{{--        </td>--}}

{{--    </tr>--}}


{{--</table>--}}

</body>
</html>

