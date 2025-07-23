<!--begin::Form-->
<form action="{{ route('admin.processes.search') }}">
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
                    <input type="text" class="form-control form-control-solid ps-10" name="user_name" value="{{ isset($user_name) ? $user_name : '' }}" placeholder="البحث" />
                </div>
                <!--end::Input group-->
                <!--begin:Action-->
                <div class="d-flex align-items-center">
                    <button type="submit" class="btn btn-primary me-5 disabledbutton">بحث</button>
                    <a id="kt_horizontal_search_advanced_link" class="btn btn-link" data-bs-toggle="collapse" href="#kt_advanced_search_form">البحث المتقدم</a>
                </div>
                <!--end:Action-->
            </div>
            <!--end::Compact form-->
            <!--begin::Advance form-->
            <div class="collapse @if( isset($process_type) || isset($time) || isset($from_date) || isset($to_date)) show @endif" id="kt_advanced_search_form">
                <!--begin::Separator-->
                <div class="separator separator-dashed mt-9 mb-6"></div>
                <!--end::Separator-->

                <!--begin::Row-->
                <div class="row g-8 mb-8">
                    <!--begin::Col-->
                    <div class="col-xxl-7">
                        <!--begin::Row-->
                        <div class="row g-8">
                            <!--begin::Col-->
                            <div class="col-lg-6">
                                <label class="fs-6 form-label fw-bold text-dark">النوع</label>
                                <!--begin::Select-->
                                <select class="form-select form-select-solid" name="process_type" data-control="select2" data-placeholder="النوع" data-hide-search="true">
                                    <option value=""></option>
                                    <option value="transfer" {{ isset($process_type) && $process_type == "transfer" ? 'selected' : '' }}>تحويلات</option>
                                    <option value="collection" {{ isset($process_type) && $process_type == "collection" ? 'selected' : '' }}>تحصيلات</option>
                                    <option value="indebtedness" {{ isset($process_type) && $process_type == "indebtedness" ? 'selected' : '' }}>المديونيات</option>
                                    <option value="repayment" {{ isset($process_type) && $process_type == "repayment" ? 'selected' : '' }}>التعويضات</option>
                                    <option value="recharge" {{ isset($process_type) && $process_type == "recharge" ? 'selected' : '' }}>شحن رصيد</option>
                                    <option value="profits" {{ isset($process_type) && $process_type == "profits" ? 'selected' : '' }}>تحويل ارباح</option>
                                </select>
                                <!--end::Select-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-lg-6">
                                <label class="fs-6 form-label fw-bold text-dark">الفترة الزمنية</label>
                                <!--begin::Select-->
                                <select class="form-select form-select-solid" name="time" data-control="select2" data-placeholder="الفترة الزمنية" data-hide-search="true">
                                    <option value=""></option>
                                    <option value="today" {{ isset($time) && $time == "today" ? 'selected' : '' }}>اليوم</option>
                                    <option value="yesterday"  {{ isset($time) && $time == "yesterday" ? 'selected' : '' }}>أمس</option>
                                    <option value="current_week"  {{ isset($time) && $time == "current_week" ? 'selected' : '' }}>الأسبوع الحالي</option>
                                    <option value="current_month" {{ isset($time) && $time == "current_month" ? 'selected' : '' }} >الشهر الحالي</option>
                                    <option value="month_ago"  {{ isset($time) && $time == "month_ago" ? 'selected' : '' }}>الشهر السابق</option>
                                    <option value="exact_time" {{ isset($time) && $time == "exact_time" ? 'selected' : '' }}>فترة محددة</option>
                                </select>
                                <!--end::Select-->
                            </div>
                            <!--end::Col-->

                        </div>
                        <!--end::Row-->
                    </div>
                    <input type="hidden" name="type" value="{{ $type }}">
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-xxl-5">
                        <!--begin::Row-->
                        <div class="row g-8">
                            <!--begin::Col-->
                            <div id="from-div" style="@if(isset($from_date)) display: block; @else display: none; @endif" class="col-lg-6">
                                <label class="fs-6 form-label fw-bold text-dark">من</label>
                                <input type="date" class="form-control form-control form-control-solid" name="from_date" value="{{ isset($from_date) ? $from_date : null }}" />

                            </div>
                            <!--end::Col-->

                            <!--begin::Col-->
                            <div id="to-div" style="@if(isset($from_date)) display: block; @else display: none; @endif" class="col-lg-6">
                                <label class="fs-6 form-label fw-bold text-dark">الى</label>
                                <input type="date" class="form-control form-control form-control-solid" name="to_date" value="{{ isset($to_date) ? $to_date : null }}" />

                            </div>
                            <!--end::Col-->

                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Advance form-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
</form>
<!--end::Form-->



