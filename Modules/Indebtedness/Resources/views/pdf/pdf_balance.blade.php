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
            مرحبا, {{ $to_user }}
        </td>
        <td style="text-align:left;">
            <img style="border: none;width: 100px;height: 100px;" src="{{ public_path('/uploads/qr-code-images/'.$qrcode)  }}" />
         <br/>

        </td>
    </tr>
</table>

<div style="clear:both;"></div>
<table style="width:100%;border:1px solid #dee2e6;">
    <tr>
        <td style="border:1px solid #dee2e6;">
            <span>بيانات الفاتورة</span>
            <br />
            <span><strong>  قام  {{ $transfer->fromAdmin->name }}  بتعويض {{ $to_user }}  المبلغ أدناه </strong></span>
            <br />
            <span><strong>    الرقم المرجعي للعملية : {{ $transfer->id }} </strong></span>
            <br />
            <span><strong>    تاريخ التحصيل : {{ $transfer->created_at->format('Y-m-d') }} </strong></span>
            <br />
            <span><strong>    نوع التحصيل : {{ collectionType($transfer->collection_type)  }} </strong></span>
            <br />
            @if($transfer->bank_name)
            <span><strong>    اسم البنك : {{ bankName($transfer->bank_name)  }} </strong></span>
            <br />
            @endif
            @if($transfer->collection_description)
            <span><strong>    تفاصيل اخرى : {{ $transfer->collection_description }} </strong></span>
            <br />
            @endif

        </td>
        <td style="border:1px solid #dee2e6;">
            <span>بيانات العميل</span>
            <br />
            <span><strong>    اسم العميل : {{ $to_user  }} </strong></span>
            <br />
            <span><strong>    رقم العميل : {{ $to_user_phone  }} </strong></span>
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
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">التاريخ</th>
         <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">الصنف</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">الكمية</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">المبلغ قبل الضريبة</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">الضريبة</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">اجمالي المبلغ </th>

    </tr>
    </thead>
    <tbody>
    <tr>
        <td>1</td>
        <td>{{ $transfer->created_at->format('Y-m-d H:i') }}</td>
        <td>تعويض</td>
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

