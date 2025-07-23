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
        <td style="text-align:center;font-size: 20px">
            نوع التقرير (مبيعات كل الموزعين )
            <br>
            من تاريخ : {{ $from_date }} الى تاريخ : {{ $to_date }}
        </td>

    </tr>
</table>

<div style="clear:both;"></div>

<table style="width:100%;border:1px solid #dee2e6;">
    <thead>
    <tr>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">#</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">اسم الموزع</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">جيديا</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">المحفظة</th>
        <th style="background-color:#eee;text-align: center;border:1px solid #dee2e6;">الكل</th>

    </tr>
    </thead>
    <tbody>
    @foreach($data as $value)
            <tr style="text-align: center;border:1px solid #dee2e6;">
                <td style="text-align: center;border:1px solid #dee2e6;">#</td>
                <td style="text-align: center;border:1px solid #dee2e6;">{{ $value['distributor_name'] }}</td>
                <td style="text-align: center;border:1px solid #dee2e6;">{{ $value['total_online'] }}</td>
                <td style="text-align: center;border:1px solid #dee2e6;">{{ $value['total_wallet'] }}</td>
                <td style="text-align: center;border:1px solid #dee2e6;">{{ $value['total_wallet'] +  $value['total_online'] }}</td>


            </tr>


    @endforeach
    <tr>
        <td  colspan="1"  class="border-right-0 border-bottom-0"></td>
        <td style="text-align: center;border:1px solid #dee2e6;">الاجمالي</td>
        <td style="text-align: center;border:1px solid #dee2e6;">{{ number_format($online_total,2) }}  </td>
        <td style="text-align: center;border:1px solid #dee2e6;">{{ number_format($wallet_total,2) }}  </td>
        <td style="text-align: center;border:1px solid #dee2e6;">{{ number_format($all_total,2) }}  </td>
  </tr>

    </tbody>
</table>
<div style="clear:both;"></div>


</body>
</html>

