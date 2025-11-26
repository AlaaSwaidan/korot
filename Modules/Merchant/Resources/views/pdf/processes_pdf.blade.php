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
    @foreach($data as $i => $value)
        <tr>
            <td>{{ $i + 1 }}</td>

            <td>
                {{ getProcessType($value->type) }}
                @if($value->type == "sales")
                    {{ $value->order->payment_method == "wallet" ? 'محفظة' : 'جيديا' }}
                @endif
            </td>

            <td>{{ $value->type == "recharge" ? $value->transaction_id : '---' }}</td>
            <td>{{ $value->amount }}</td>

            {{-- Transfers --}}
            <td>{{ $value->type == "transfer" ? $totals->total_transfers : '' }}</td>

            {{-- Collections --}}
            <td>{{ $value->type == "collection" ? $totals->total_collections : '' }}</td>

            {{-- Indebtedness / Payment --}}
            <td>{{ in_array($value->type, ['indebtedness','payment']) ? $totals->total_indebtedness : '' }}</td>

            {{-- Repayment --}}
            <td>{{ $value->type == "repayment" ? $totals->total_repayment : '' }}</td>

            {{-- Profits (profit per row + total profits) --}}
            <td>{{ in_array($value->type, ['profits','sales']) ? $value->profits : '' }}</td>

            <td>{{ in_array($value->type, ['profits','sales']) ? $totals->total_profits + $totals->total_sales_profits : '' }}</td>

            <td>{{ $value->balance_total }}</td>
            <td>{{ $value->created_at->format('Y-m-d g:i A') }}</td>

        </tr>
    @endforeach
    </tbody>

</table>
</body>
</html>

