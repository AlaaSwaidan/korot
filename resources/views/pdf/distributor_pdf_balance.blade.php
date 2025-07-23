<!DOCTYPE html>
<html direction="rtl" dir="rtl" style="direction: rtl">
<head>
    <meta charset="utf-8" />
    <title> تحويل رصيد رقمي</title>
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
            مرحبا, {{ $to_user }}
        </td>

    </tr>
</table>

<div style="clear:both;"></div>

<table style="width:100%;border:1px solid #dee2e6;">
    <tr>
        <td style="border:1px solid #dee2e6;">
            <span>بيانات تحويل رصيد رقمي</span>
            <br />
            <span><strong>  شحن من  {{ $transfer->fromAdmin->name }}  الى  {{ $to_user }}  </strong></span>
            <br />
            <span><strong>    الرقم المرجعي للعملية : {{ $transfer->id }} </strong></span>
            <br />
            <span><strong>    تاريخ التحويل : {{ $transfer->created_at->format('Y-m-d') }} </strong></span>
            <br />
            @if($transfer->transfer_type  == "fawry")
                <span><strong>    نوع التحصيل : {{ collectionType($transfer->collection_type)  }} </strong></span>
                <br />
                <span><strong>    اسم البنك : {!!  ($transfer->bank_name  ? $transfer->bank->name['ar'] : '')  !!} </strong></span>
                <br />
            @endif
        </td>
        <td style="border:1px solid #dee2e6;">
            <span>بيانات العميل</span>
            <br />
            <span><strong>اسم العميل : {{ $to_user }} </strong></span>
            <br />
            <span><strong> رقم العميل : {{ $to_user_phone }} </strong></span>
            <br />
            @if(isset($to_user_tax_number))
                <span><strong> رقم الضريبي : {{ $to_user_tax_number }} </strong></span>
                <br />
            @endif
            @if(isset($to_user_commercial_number))
                <span><strong> السجل التجاري : {{ $to_user_commercial_number }} </strong></span>
                <br />
            @endif



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
         <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">الصنف</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">الكمية</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">المبلغ قبل الضريبة</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">الضريبة</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">اجمالي المبلغ المستحق</th>

    </tr>
    </thead>
    <tbody>
    <tr>
        <td>1</td>
        <td>{{ $transfer->created_at->format('Y-m-d H:i') }}</td>
        <td>شحن الكتروني</td>
        <td>{{ $transfer->amount }} ر.س</td>
        <td>{{ $transfer->amount }} ر.س</td>
        <td>مدفوعة الضريبة</td>
        <td>{{ $transfer->amount }} ر.س</td>
    </tr>

    </tbody>
</table>
<div style="clear:both;"></div>


</body>
</html>

