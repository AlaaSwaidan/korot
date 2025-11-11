{{--@php--}}
{{--    // Group only the paginated items--}}
{{--    $grouped = $invoices->getCollection()->groupBy('merchant_id');--}}
{{--@endphp--}}
{{--@foreach($grouped as $index => $invoice)--}}
{{--    @include('admin.external_services.invoice_row', ['invoice' => $invoice, 'index' => $index])--}}
{{--@endforeach--}}
@foreach($invoices as $index => $invoice)
    @php
        $merchant = $invoice->merchant;
        $monthYear = request()->get('date', now()->format('Y-m'));
        [$year, $month] = explode('-', $monthYear);
        $monthYearId = $year . sprintf('%02d', $month) . '-' . $merchant->id;
        $lastDay = \Carbon\Carbon::createFromFormat('Y-m', $monthYear)->endOfMonth()->toDateString();
    @endphp

    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $monthYearId }}</td>
        <td>{{ $merchant->id }}</td>
        <td>{{ $merchant->name }}</td>
        <td>{{ $merchant->tax_number }}</td>
        <td>{{ $merchant->commercial_number }}</td>
        <td>{{ optional($merchant->city)->name_ar }}</td>
        <td><div class="badge badge-light-success">{{ number_format($invoice->total_price, 2) }} ر.س</div></td>
        <td>{{ $lastDay }}</td>
        <td>
            <button class="btn btn-sm btn-light-primary btn-show-items"
                    data-merchant-id="{{ $merchant->id }}"
                    data-date="{{ $monthYear }}">
                عرض العناصر
            </button>
        </td>
    </tr>
    <tr class="bg-light collapse-row" id="items-row-{{ $merchant->id }}" style="display:none;">
        <td colspan="10">
            <div class="items-container"></div>
        </td>
    </tr>
@endforeach
