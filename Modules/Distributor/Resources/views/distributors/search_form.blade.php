<!--begin::Form-->
<form action="{{ route('admin.distributors.profile-accounts',$distributor->id) }}">
    <!--begin::Card-->
    <div class="card mb-7">
        <!--begin::Card body-->
        <div class="card-body">
            <!--begin::Compact form-->
            <div class="d-flex align-items-center">
                <!--begin::Input group-->
                <div class="position-relative w-md-400px me-md-2">
                    <!--begin::Col-->
                    <div class="col-lg-6">
                        <label class="fs-6 form-label fw-bold text-dark">الفترة الزمنية</label>
                        <!--begin::Select-->
                        <select class="form-select form-select-solid" name="time" data-control="select2" data-placeholder="الفترة الزمنية" data-hide-search="true">
                            <option value=""></option>
                            <option value="today" {{ isset($time) && $time == "today" ? 'selected' : '' }}>اليوم</option>
                           <option value="exact_time" {{ isset($time) && $time == "exact_time" ? 'selected' : '' }}>فترة محددة</option>
                        </select>
                        <!--end::Select-->
                    </div>
                    <!--end::Col-->
                    <input type="hidden" name="type" value="distributors">
                    <!--end::Col-->
                    <!--begin::Row-->
                    <div class="row g-8">
                        <!--begin::Col-->
                        <div id="from-div" style="@if(isset($startDate)) display: block; @else display: none; @endif" class="col-lg-6">
                            <label class="fs-6 form-label fw-bold text-dark">من</label>
                            <input type="date" class="form-control form-control form-control-solid" name="from_date" value="{{ isset($startDate) ? $startDate->format('Y-m-d') : null }}" />
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div id="to-div" style="@if(isset($startDate)) display: block; @else display: none; @endif" class="col-lg-6">
                            <label class="fs-6 form-label fw-bold text-dark">الى</label>
                            <input type="date" class="form-control form-control form-control-solid" name="to_date" value="{{ isset($endDate) ? $endDate->format('Y-m-d') : null }}" />

                        </div>
                        <!--end::Col-->

                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Input group-->
                <!--begin:Action-->
                <div class="d-flex">
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



