<?php $i = 0; ?>
@foreach($data as $value )
        <?php ++$i; ?>
    <tr>
        <!--begin::Checkbox-->
        <td>
            <div class="form-check form-check-sm form-check-custom form-check-solid">
                <input class="form-check-input" type="checkbox" value="{{ $value->id }}" />
            </div>
        </td>
        <!--end::Checkbox-->
        <td> {{ $i }} </td>

        <!--begin::Customer=-->
        <td>
            {{ $value->package->category->company->name['ar'] }}
        </td>
        <!--end::Customer=-->
        <!--begin::Customer=-->
        <td>
            {{ $value->package->name['ar'] }}
            <input type="hidden" name="id[{{$value->id }}]" value="{{ $value->id }}">
        </td>
        <!--end::Customer=-->
        <td>
            <div class="badge badge-light-info">  {{ $value->old_price }}</div>
        </td>
        <!--begin::Status=-->
        <td>
            <input type="text" class="form-control form-control-solid ps-10" name="price[{{ $value->id }}]" value="{{ $value->price }}" placeholder="السعر الجديد" />
        </td>
        <!--end::Status=-->

    </tr>
@endforeach
@if(isset($result))
@foreach($result as $item )
        <?php ++$i; ?>
    <tr>
        <!--begin::Checkbox-->
        <td>
            <div class="form-check form-check-sm form-check-custom form-check-solid">
                <input class="form-check-input" type="checkbox" value="{{ $item->id }}" />
            </div>
        </td>
        <!--end::Checkbox-->
        <td> {{ $i }} </td>

        <!--begin::Customer=-->
        <td>
            {{ $item->category->company->name['ar'] }}
        </td>
        <!--end::Customer=-->
        <!--begin::Customer=-->
        <td>
            {{ $item->name['ar'] }}
            <input type="hidden" name="package_id[{{$item->id }}]" value="{{ $item->id }}">
        </td>
        <!--end::Customer=-->
        <td>
            <div class="badge badge-light-info">  {{ $item->prices()->where('type',$merchant->type)->first()->price }}</div>
        </td>
        <!--begin::Status=-->
        <td>
            <input type="text" class="form-control form-control-solid ps-10" name="new_price[{{ $item->id }}]" value="" placeholder="السعر الجديد" />
        </td>
        <!--end::Status=-->

    </tr>
@endforeach
@endif

