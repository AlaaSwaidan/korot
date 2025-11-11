<tr>
    <td>{{ $index + 1 }}</td>
    <td>{{ $invoice['InvoiceID'] }}</td>
    <td>{{ $invoice['Customer']['Name'] ?? '-' }}</td>
    <td>{{ $invoice['Customer']['City'] ?? '-' }}</td>
    <td><div class="badge badge-light-success">{{ number_format($invoice['Total'], 2) }} ر.س</div></td>
    <td>{{ $invoice['InvoiceDate'] }}</td>
    <td>
        <button class="btn btn-sm btn-light-primary" data-bs-toggle="collapse" data-bs-target="#items-{{ $index }}">
            عرض العناصر
        </button>
    </td>
</tr>

<tr class="collapse bg-light" id="items-{{ $index }}">
    <td colspan="7">
        <table class="table table-bordered align-middle mt-3">
            <thead class="bg-secondary text-white">
            <tr>
                <th>الكود</th>
                <th>اسم العنصر</th>
                <th>الكمية</th>
                <th>الإجمالي</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoice['Items'] as $item)
                <tr>
                    <td>{{ $item['ItemCode'] }}</td>
                    <td>{{ $item['ItemName'] }}</td>
                    <td>{{ $item['Quantity'] }}</td>
                    <td>{{ number_format($item['Total'], 2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </td>
</tr>
