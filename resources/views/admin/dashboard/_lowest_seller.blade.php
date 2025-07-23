@foreach($lowest_merchants_sellers as $most)
    <tr>
        <td>
            <div class="d-flex align-items-center">
                <div class="symbol symbol-50px me-3">
                    <img src="{{ $most->merchant->image_full_path }}" class="" alt="" />
                </div>
                <div class="d-flex justify-content-start flex-column">
                    <span class="text-gray-400 fw-semibold d-block fs-7">{{ $most->merchant->name }}</span>
                </div>
            </div>
        </td>
        <td class=" pe-0">
            {{ $most->sums }}
        </td>
        <td class=" pe-0">
            {{ $most->total }}
        </td>
        <td class="text-end">
            {{ number_format($most->profits,2) }}
        </td>
    </tr>
@endforeach
