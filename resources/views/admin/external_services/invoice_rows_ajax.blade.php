@foreach($invoices as $index => $invoice)
    @php $rowIndex = $startIndex + $index + 1; @endphp
    @include('admin.external_services.invoice_row', ['invoice' => $invoice, 'index' => $rowIndex])
@endforeach
