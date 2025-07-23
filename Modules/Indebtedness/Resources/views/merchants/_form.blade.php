<!--begin::Card body-->
<div class="card-body">
        <!--begin::Input group-->
        <div class="fv-row row mb-15">
            <!--begin::Col-->
            <div class="col-md-3 d-flex align-items-center">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold">المبلغ</label>
                <!--end::Label-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-9">
                <!--begin::Input-->
                <input type="text"  class="form-control form-control-lg form-control-solid" name="amount" placeholder="المبلغ"
                       value="{{ isset($merchant) ? $merchant->amount : old('amount') }}">
                <!--end::Input-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Input group-->

        <!--begin::Action buttons-->
        <div class="row mt-12">
            <div class="col-md-9 offset-md-3">
                <!--begin::Button-->
                <button type="submit" class="btn btn-primary" >
                    <span class="indicator-label">حفظ</span>

                </button>
                <!--end::Button-->
            </div>
        </div>
        <!--begin::Action buttons-->

</div>
<!--end::Card body-->
