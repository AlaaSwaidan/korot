@php
    // Group only the paginated items
    $grouped = $invoices->getCollection()->groupBy('merchant_id');
@endphp
@foreach($grouped as $index => $invoice)
    @include('admin.external_services.invoice_row', ['invoice' => $invoice, 'index' => $index])
@endforeach
