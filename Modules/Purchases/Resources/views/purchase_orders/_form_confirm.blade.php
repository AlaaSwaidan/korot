<!--begin::Card body-->
<div class="card-body">
    <!--begin::Input group-->
    <div class="row g-9 mb-8">
        <!--begin::Col-->
        <div class="col-md-6 fv-row">
            <label class="required fs-6 fw-semibold mb-2">اسم المورد</label>
            <select class="form-select form-select-solid" data-control="select2" id="supplier_id" data-hide-search="true" data-placeholder="اسم المورد" name="supplier_id">
               <option value="">اختر المورد</option>
                @foreach($suppliers as $supplier)
                    <option data-code="{{ $supplier->supplier_id }}"  value="{{ $supplier->id }}" {{ isset($purchaseOrder) ? ($purchaseOrder->supplier_id == $supplier->id ? 'selected' : '') : (old('supplier_id') == $supplier->id ? 'selected' : '') }}>{{ $supplier->name }}</option>
                @endforeach
            </select>
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-6 fv-row">
            <label class="required fs-6 fw-semibold mb-2">كود المورد</label>
            <!--begin::Input-->
            <div class="position-relative d-flex align-items-center">
                <!--begin::Icon-->
                <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                <input type="text"  class="form-control form-control-lg form-control-solid" id="supplier_code" name="supplier_code" placeholder="كود المورد"
                       value="{{ isset($purchaseOrder) ? $purchaseOrder->supplier_id : old('supplier_code') }}" disabled>
                <!--end::Input-->
            </div>
            <!--end::Input-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="row g-9 mb-8">
        <!--begin::Col-->
        <div class="col-md-6 fv-row">
            <label class="required fs-6 fw-semibold mb-2">العملة</label>
            <select class="form-select form-select-solid" data-control="select2" id="currency_id" data-hide-search="true" data-placeholder="اسم العملة" name="currency_id">
               <option value="">اختر العملة</option>
                @foreach($currencies as $currency)
                    <option   value="{{ $currency->id }}" {{ isset($purchaseOrder) ? ($purchaseOrder->currency_id == $currency->id ? 'selected' : '') : (old('currency_id') == $currency->id ? 'selected' : '') }}>{{ $currency->name }}</option>
                @endforeach
            </select>
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-6 fv-row">
            <label class="required fs-6 fw-semibold mb-2">تاريخ أمر الشراء </label>
            <!--begin::Input-->
            <div class="position-relative d-flex align-items-center">
                <!--begin::Icon-->
                <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                <input type="date"  class="form-control form-control-lg form-control-solid" id="purchase_order_date" name="purchase_order_date"
                       value="{{ isset($purchaseOrder) ? $purchaseOrder->purchase_order_date : old('purchase_order_date') }}" >
                <!--end::Input-->
            </div>
            <!--end::Input-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Input group-->

    <!--begin::Input group-->
    <div class="row g-9 mb-8">
        <!--begin::Col-->
        <div class="col-md-6 fv-row">
            <label class="required fs-6 fw-semibold mb-2">تاريخ الاستلام </label>
            <!--begin::Input-->
            <div class="position-relative d-flex align-items-center">
                <!--begin::Icon-->
                <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                <input type="date"  class="form-control form-control-lg form-control-solid" id="received_date" name="received_date"
                       value="{{ isset($purchaseOrder) ? $purchaseOrder->received_date : old('received_date') }}" >
                <!--end::Input-->
            </div>
            <!--end::Input-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Input group-->
    @if(isset($purchaseOrder))
    <!--begin::Input group-->
    <div class="row g-9 mb-8">
        <!--begin::Col-->
        <div class="col-md-6 fv-row">
            <label class="required fs-6 fw-semibold mb-2">البنوك </label>
            <!--begin::Input-->
            <div class="position-relative d-flex align-items-center">
                <select class="form-select form-select-solid" data-control="select2" id="bank_id" data-hide-search="true" data-placeholder="اسم البنك" name="bank_id">
                    <option value="">اختر البنك</option>
                    @foreach($banks as $bank)
                        <option   value="{{ $bank->id }}" {{ isset($purchaseOrder) ? ($purchaseOrder->bank_id == $bank->id ? 'selected' : '') : (old('bank_id') == $bank->id ? 'selected' : '') }}>{{ $bank->name['ar'] }}</option>
                    @endforeach
                </select>
            </div>
            <!--end::Input-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-6 fv-row">
            <label class="required fs-6 fw-semibold mb-2">تاريخ الدفع </label>
            <!--begin::Input-->
            <div class="position-relative d-flex align-items-center">
                <!--begin::Icon-->
                <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                <input type="date"  class="form-control form-control-lg form-control-solid" id="confirm_date" name="confirm_date"
                       value="{{ isset($purchaseOrder) ? $purchaseOrder->confirm_date : old('confirm_date') }}" >
                <!--end::Input-->
            </div>
            <!--end::Input-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Input group-->
    @endif
    <!--begin::Input group-->
    <div class="row g-9 mb-8">
        <!--begin::Col-->
        <div class="col-md-6 fv-row">
            <label class="required fs-6 fw-semibold mb-2">المنتجات </label>
            <!--begin::Input-->
            <div class="position-relative d-flex align-items-center">
                <!--begin::Icon-->
                <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                <button type="button" class="btn btn-info mb-3" id="addrow2" value="+" >+</button>
                <!--end::Input-->
            </div>
            <!--end::Input-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row row mb-15">
            <table class="table align-middle table-row-dashed fs-6 gy-5 order-list ItemTable" id="kt_subscriptions_table">
                <thead>
                <tr>
                    <td style="min-width: 350px;" >اسم الباقة</td>
                    <td >الكمية</td>
                    <td >السعر</td>
                    <td style="width: 150px">اختيار الضريبة</td>
                    <td >الضريبة</td>
                    <td >نسبة الخصم</td>
                    <td >الاجمالي</td>
                </tr>
                </thead>
                <tbody id="tablecontents">
                @if( isset($purchaseOrder) )
                        <?php $i =0; ?>
                    @foreach($purchaseProducts as $data)

                        <tr>
                            <td style="padding: 0;">
                                <div id="accounts_attributes{{$i}}">
                                    <select class="form-control selectpicker products" data-live-search="true"  data-style="btn-light" name="products[{{$i}}]"  >
                                        <option value="">اختر الباقة</option>
                                        <option value="digital_balance" {{ isset($purchaseOrder) &&  $data->product_id  == "digital_balance" ? "selected" : "" }}>الرصيد الرقمي</option>
                                        @foreach($packages as $package)
                                            <option value="{{$package->id}}" data-index="{{ $i }}" data-rc="{{ $package->cost }}" {{ isset($purchaseOrder) &&  $package->id == $data->product_id ? "selected" : "" }}> {{  $package->category->company->name['ar'] .' - '. $package->category->name['ar'] .' - '. $package->name['ar']  }}</option>

                                        @endforeach
                                    </select>
                                </div>
                            </td>

                            <td style="padding: 0;">
                                <input type="text" id="quantity[{{$i}}]"  name="quantity[{{$i}}]"  class="form-control quantity" placeholder="الكمية" value="{{isset($purchaseOrder) ? $data->quantity : null }}" parsley-trigger="change" required >
                            </td>
                            <td style="padding: 0;">
                                <input type="text" id="price[{{ $i }}]"  name="price[{{$i}}]" class="form-control price" placeholder="السعر" value="{{isset($purchaseOrder) ? $data->price : null }}"  parsley-trigger="change" required />
                            </td>
                            <td style="padding: 0;">

                                <select class="form-control selectpicker choose_tax" data-live-search="true"  data-style="btn-light" name="choose_tax[{{$i}}]"  >
                                    <option value="no_tax" data-index="{{$i}}"  {{ isset($purchaseOrder) &&  $data->choose_tax  == "no_tax" ? "selected" : "" }}>غير شامل الضريبة</option>
                                    <option value="with_tax" data-index="{{$i}}"  {{ isset($purchaseOrder) &&  $data->choose_tax  == "with_tax" ? "selected" : "" }}>شامل الضريبة</option>
                                </select>

                            </td>
                            <td style="padding: 0;">
                                <input type="text" id="tax[{{$i}}]"   name="tax[{{$i}}]" class="form-control  tax_percentage" placeholder="الضريبة" value="{{isset($purchaseOrder) ? $data->tax : 0 }}"  parsley-trigger="change" required />
                            </td>

                            <td style="padding: 0;">
                                <input type="text" id="discount_amount[{{$i}}]"   name="discount_amount[{{$i}}]" class="form-control  discount_amount" placeholder="نسبة الخصم" value="{{isset($purchaseOrder) ? $data->discount_amount : 0 }}"  parsley-trigger="change" required />
                            </td>

                            <td style="padding: 0;">
                                <input type="text"   id="total[{{$i}}]"  name="total[{{$i}}]" class="form-control" placeholder="الاجمالي" value="{{isset($purchaseOrder) ? $data->total : null }}"  >
                            </td>

                            @if( $i > 1)
                                <td style="padding: 0;"><input type="button" class="ibtnDel btn btn-md btn-danger "  value="{{trans('messages.delete')}}"></td>
                            @endif
                            <td style="padding: 0;"><a class="deleteRow"></a>
                            </td>

                        </tr>
                            <?php $i++; ?>
                    @endforeach
                    <input type="hidden" id="i_of_id" value="{{$i}}">
                @else
                    <tr>
                        <td style="padding: 0;">
                            <div id="accounts_attributes0">
                                <select class="form-control products" data-live-search="true"  data-style="btn-light" name="products[0]"  >
                                    <option value="">اختر الباقة</option>
                                    <option value="digital_balance">الرصيد الرقمي</option>
                                    @foreach($packages as $package)

                                        <option value="{{$package->id}}" data-index="0" data-rc="{{ $package->cost }}" > {{  $package->category->company->name['ar'] .' - '. $package->category->name['ar'] .' - '. $package->name['ar']  }}</option>

                                    @endforeach
                                </select>
                            </div>
                        </td>

                        <td style="padding: 0;">
                            <input type="text"  id="quantity[0]" name="quantity[0]"  class="form-control quantity" placeholder="الكمية" value="{{isset($purchaseOrder) ? $purchaseOrder->quantity : null }}" parsley-trigger="change" required >
                        </td>
                        <td style="padding: 0;">
                            <input type="text"  id="price[0]"  name="price[0]" class="form-control price" placeholder="السعر" value="{{isset($purchaseOrder) ? $purchaseOrder->price : null }}"  >
                        </td>
                        <td style="padding: 0;">

                                <select class="form-control selectpicker choose_tax" data-live-search="true"  data-style="btn-light" name="choose_tax[0]"  >
                                    <option value="no_tax" data-index="0"  >غير شامل الضريبة</option>
                                    <option value="with_tax" data-index="0"  >شامل الضريبة</option>
                                </select>

                        </td>
                        <td style="padding: 0;">
                            <input type="text"  id="tax[0]"  name="tax[0]" class="form-control tax_percentage" placeholder="الضريبة" value="{{isset($purchaseOrder) ? $purchaseOrder->tax : 0 }}"  >
                        </td>
                        <td style="padding: 0;">
                            <input type="text"  id="discount_amount[0]"  name="discount_amount[0]" class="form-control discount_amount" placeholder="نسبة الخصم" value="{{isset($purchaseOrder) ? $purchaseOrder->discount_amount : 0 }}"  >
                        </td>
                        <td style="padding: 0;">
                            <input type="text"  id="total[0]"  name="total[0]" class="form-control total" placeholder="الاجمالي" value="{{isset($purchaseOrder) ? $purchaseOrder->total : null }}"  >
                        </td>
                        <td style="padding: 0;"><a class="deleteRow"></a>

                        </td>
                    </tr>

                @endif
                </tbody>

            </table>
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="row g-9 mb-8">
            <!--begin::Col-->
            <div class="col-md-6 fv-row">
                <label class="required fs-6 fw-semibold mb-2">اجمالي قبل الضريبة </label>
                <!--begin::Input-->
                <div class="position-relative d-flex align-items-center">
                    <!--begin::Icon-->
                    <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                    <input type="number"  class="form-control form-control-lg form-control-solid" id="total_before_tax" name="total_before_tax"
                           value="{{ isset($purchaseOrder) ? $purchaseOrder->total_before_tax : old('total_before_tax') }}" >
                    <!--end::Input-->
                </div>
                <!--end::Input-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-6 fv-row">
                <label class="required fs-6 fw-semibold mb-2">مبلغ الضريبة </label>
                <!--begin::Input-->
                <div class="position-relative d-flex align-items-center">
                    <!--begin::Icon-->
                    <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                    <input type="number"  class="form-control form-control-lg form-control-solid" id="tax_amount" name="tax_amount"
                           value="{{ isset($purchaseOrder) ? $purchaseOrder->tax_amount : old('tax_amount') }}" >
                    <!--end::Input-->
                </div>
                <!--end::Input-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="row g-9 mb-8">
            <!--begin::Col-->
            <div class="col-md-6 fv-row">
                <label class="required fs-6 fw-semibold mb-2">مبلغ الخصم </label>
                <!--begin::Input-->
                <div class="position-relative d-flex align-items-center">
                    <!--begin::Icon-->
                    <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                    <input type="number"  class="form-control form-control-lg form-control-solid" id="total_discount_amount" name="total_discount_amount"
                           value="{{ isset($purchaseOrder) ? $purchaseOrder->total_discount_amount : old('total_discount_amount') }}" >
                    <!--end::Input-->
                </div>
                <!--end::Input-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-6 fv-row">
                <label class="required fs-6 fw-semibold mb-2">اجمالي بعد الضريبة </label>
                <!--begin::Input-->
                <div class="position-relative d-flex align-items-center">
                    <!--begin::Icon-->
                    <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                    <input type="number"  class="form-control form-control-lg form-control-solid" id="total_after_tax" name="total_after_tax"
                           value="{{ isset($purchaseOrder) ? $purchaseOrder->total_after_tax : old('total_after_tax') }}" >
                    <!--end::Input-->
                </div>
                <!--end::Input-->
            </div>
            <!--end::Col-->

        </div>
        <!--end::Input group-->

        <!--begin::Action buttons-->
        <div class="row mt-12">
            <div class="col-md-9 offset-md-3">
                <!--begin::Button-->
                <button type="submit" class="btn btn-primary" id="save" value="Save">
                    <span class="indicator-label">تأكيد</span>
                </button>
                <!--end::Button-->
            </div>
        </div>
        <!--begin::Action buttons-->

</div>
<!--end::Card body-->
