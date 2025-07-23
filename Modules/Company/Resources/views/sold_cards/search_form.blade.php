<!--begin::Form-->
<form action="{{ route('admin.sold-cards.search') }}">
    <!--begin::Card-->
    <div class="card mb-7">
        <!--begin::Card body-->
        <div class="card-body">
            <!--begin::Compact form-->
            <div class="d-flex align-items-center">
                <!--begin::Input group-->
                <div class="position-relative w-md-400px me-md-2">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                    <span class="svg-icon svg-icon-3 svg-icon-gray-500 position-absolute top-50 translate-middle ms-6">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <input type="text" class="form-control form-control-solid ps-10" name="card_num" value="{{ isset($card_name) ? $card_name : '' }}" placeholder="البحث برقم البطاقة او الرقم التسلسلي" />
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="position-relative w-md-400px me-md-2">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                    <span class="svg-icon svg-icon-3 svg-icon-gray-500 position-absolute top-50 translate-middle ms-6">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <input type="text" class="form-control form-control-solid ps-10" name="transaction_id" value="{{ isset($transaction_id) ? $transaction_id : '' }}" placeholder="البحث برقم العملية" />
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



