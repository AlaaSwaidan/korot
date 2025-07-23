<!--begin::Form-->
<form action="{{ route('admin.journals.search') }}">
    <!--begin::Card-->
    <div class="card mb-7">
        <!--begin::Card body-->
        <div class="card-body">
            <!--begin::Compact form-->
            <div class="d-flex align-items-center">
                <!--begin::Input group-->
                <div class="position-relative w-md-400px me-md-2">
                    <!--begin::Col-->

                    <!--begin::Col-->
                    <div id="from-div"  class="col-lg-6">
                        <label class="fs-6 form-label fw-bold text-dark">من</label>
                        <input type="date" class="form-control form-control form-control-solid" name="from_date" value="{{ isset($from_date) ? $from_date : null }}" />

                    </div>
                    <!--end::Col-->

                    <!--begin::Col-->
                    <div id="to-div"  class="col-lg-6">
                        <label class="fs-6 form-label fw-bold text-dark">الى</label>
                        <input type="date" class="form-control form-control form-control-solid" name="to_date" value="{{ isset($to_date) ? $to_date : null }}" />

                    </div>
                    <!--end::Col-->



                    <!--end::Col-->
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



