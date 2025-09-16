<!--begin::Form-->
<form action="{{ route('admin.reports-sales-cards.index') }}">
    <!--begin::Card-->
    <div class="card mb-7">
        <!--begin::Card body-->
        <div class="card-body">
            <!--begin::Compact form-->
            <div class="d-flex align-items-center">
                <!--begin::Input group-->
{{--                <div class="position-relative w-md-400px me-md-2">--}}
{{--                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->--}}
{{--                    <span class="svg-icon svg-icon-3 svg-icon-gray-500 position-absolute top-50 translate-middle ms-6">--}}
{{--                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />--}}
{{--                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />--}}
{{--                        </svg>--}}
{{--                    </span>--}}
{{--                    <!--end::Svg Icon-->--}}
{{--                    <input type="text" class="form-control form-control-solid ps-10" name="card_num" value="{{ isset($card_name) ? $card_name : '' }}" placeholder="البحث برقم البطاقة او الرقم التسلسلي" />--}}
{{--                </div>--}}
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="position-relative w-md-400px me-md-2">
                    <lable>من</lable>
                    <!--begin::Col-->
                    <input type="date" class="form-control form-control form-control-solid" name="from_date" value="{{ isset($from_date) ? $from_date : null }}" />

                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="position-relative w-md-400px me-md-2">
                    <label>الى</label>
                    <!--begin::Col-->
                    <input type="date" class="form-control form-control form-control-solid" name="to_date" value="{{ isset($to_date) ? $to_date : null }}" />

                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="position-relative w-md-400px me-md-2">
                     <label>شركات</label>
                    <!--begin::Col-->
                        <!--begin::Select-->
                        <select class="form-select form-select-solid" name="company_id" data-control="select2" data-placeholder="الشركات" data-hide-search="true">
                        <option value="">اختر </option>
                         @foreach($companies as $company)
                             <option value="{{ $company->id }}" {{ isset($company_id) && $company_id == $company->id ? 'selected' : '' }}>{{ $company->name['ar'] }}</option>
                         @endforeach
                          </select>
                        <!--end::Select-->

                    <!--end::Col-->

                 </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="position-relative w-md-400px me-md-2">
                    <!--begin::Col-->
                    <div   id="all-categories">
                        @if(isset($company_id))
                            <label>الفئات</label>
                            <!--begin::Select-->
                            <select class="form-select form-select-solid" name="category_id" data-control="select2" data-placeholder="الفئات" data-hide-search="false">
                                <option value=""></option>
                                @foreach(\App\Models\Store::where('parent_id',$company_id)->orderBy('id','desc')->get() as $category)
                                    <option value="{{ $category->id }}" {{ isset($category_id) && $category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name['ar'] }}</option>
                                @endforeach
                            </select>
                            <!--end::Select-->
                        @endif
                    </div>
                    <!--end::Col-->

                 </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="position-relative w-md-400px me-md-2">
                    <div   id="all-packages">
                        @if(isset($category_id))
                            <label>الباقات</label>
                            <!--begin::Select-->
                            <select class="form-select form-select-solid" name="package_id" data-control="select2" data-placeholder="الباقات" data-hide-search="false">
                                <option value=""></option>
                                @foreach(\App\Models\Package::where('store_id',$category_id)->orderBy('id','desc')->get() as $package)
                                    <option value="{{ $package->id }}" {{ isset($package_id) && $package_id == $package->id ? 'selected' : '' }}>
                                        {{ $package->name['ar'] }}</option>
                                @endforeach
                            </select>
                            <!--end::Select-->
                        @endif
                    </div>

                 </div>
                <!--end::Input group-->
                <!--begin:Action-->
                <div class="d-flex align-items-center">
                    <button type="submit" class="btn btn-primary me-5 disabledbutton">بحث</button>

                </div>
                <!--end:Action-->
            </div>
            <!--end::Compact form-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
</form>
<form action="{{route('admin.reports.sales-cards-reports-excel')}}" method="post" >
    @csrf

    <button type="submit"  class="btn btn-success disabledbutton">
        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
        <i class="fas fa-file-excel"></i>
        <!--end::Svg Icon-->
    </button>
    <input type="hidden" name="category_id" value="{{ isset($category_id)? $category_id : null }}">
    <input type="hidden" name="package_id" value="{{ isset($package_id)? $package_id : null }}">
    <input type="hidden" name="company_id" value="{{ isset($company_id)? $company_id : null }}">
    <input type="hidden" name="from_date" value="{{ isset($from_date)? $from_date : null }}">
    <input type="hidden" name="to_date" value="{{ isset($to_date)? $to_date : null }}">
</form>

<!--end::Form-->
{{--<form action="{{route('admin.sold-cards.transaction-excel')}}" method="post" style="margin-bottom: 10px;">--}}
{{--    @csrf--}}

{{--    <button type="submit"  class="btn btn-success disabledbutton">--}}
{{--        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->--}}
{{--        <i class="fas fa-file-excel"></i>--}}
{{--        <!--end::Svg Icon-->--}}
{{--    </button>--}}
{{--    <input type="hidden" name="card_num" value="{{isset($card_num) ?  $card_num : null }}">--}}
{{--    <input type="hidden" name="transaction_id" value="{{ isset($transaction_id) ? $transaction_id : null }}">--}}

{{--</form>--}}



