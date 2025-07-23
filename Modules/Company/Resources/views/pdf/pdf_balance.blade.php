<!DOCTYPE html>
<html direction="rtl" dir="rtl" style="direction: rtl">
<head>
    <meta charset="utf-8" />
    <title>لوحة التحكم | فاتورة</title>
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
            مرحبا, {{ $merchant_name }}
        </td>
    </tr>
</table>

<div style="clear:both;"></div>
<table style="width:100%;border:1px solid #dee2e6;">
    <tr>
        <td style="border:1px solid #dee2e6;">
            <span>بيانات الفاتورة</span>
            <br/>
            <span><strong>  اسم الشركة : {{ $order->company_name[app()->getLocale()] }}  </strong></span>
            <br/>
            <span><strong>  اسم البطاقة : {{ $order->name[app()->getLocale()] }}  </strong></span>
            <br/>
            <span><strong>  نوع البطاقة : {{ $order->package->category->name[app()->getLocale()] }}  </strong></span>
            <br/>
            <span><strong>  طريقة الدفع : {{ $payment_method == "wallet" ? 'محفظة' : "جيديا" }}  </strong></span>
            <br/>
            @if($payment_method == "online")
                <span><strong>    الرقم المرجعي للعملية : {{ $transaction_id }} </strong></span>
                <br/>
            @endif
        </td>
        <td style="border:1px solid #dee2e6;">
            <span>بيانات التاجر</span>
            <br/>
            <span><strong>    اسم التاجر : {{ $merchant_name  }} </strong></span>
            <br/>
            <span><strong>    رقم التاجر : {{ $merchant_phone  }} </strong></span>
            <br/>
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
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">التاريخ</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">اسم التاجر</th>
         <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">رقم البطاقة</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">الرقم التسلسلي	</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">المبلغ	</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">تاريخ الانتهاء	</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">رقم العملية</th>

    </tr>
    </thead>
    <tbody>
    <tr>
        <td>1</td>
        <td>{{ $card->created_at->format('Y-m-d H:i') }}</td>
        <td>{{ $merchant_name }}</td>
        <td> {{ $card->card_number }}</td>
        <td> {{ $card->serial_number }}</td>
        <td>{{ $order->card_price }} ر.س</td>
        <td>{{ $card->end_date }}</td>
        <td>{{ $transaction_id }}</td>
    </tr>

    </tbody>
</table>
<div style="clear:both;"></div>


</body>
</html>

