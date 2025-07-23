<div class="card-body">
<!--begin::Tap pane-->
    <!--begin::Input group-->
    <div class="fv-row row mb-15">
        <!--begin::Col-->
        <div class="col-md-3 d-flex align-items-center">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold">رقم البطاقة</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"  class="form-control form-control-lg form-control-solid" name="card_number" placeholder="رقم البطاقة"
                   value="{{ isset($card) ? $card->card_number : old('card_number') }}">
            <!--end::Input-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row row mb-15">
        <!--begin::Col-->
        <div class="col-md-3 d-flex align-items-center">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold">الرقم التسلسلي</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"  class="form-control form-control-lg form-control-solid" name="serial_number" placeholder="الرقم التسلسلي"
                   value="{{ isset($card) ? $card->serial_number : old('serial_number') }}">
            <!--end::Input-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row row mb-15">
        <!--begin::Col-->
        <div class="col-md-3 d-flex align-items-center">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold">تاريخ الانتهاء</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="date"  class="form-control form-control-lg form-control-solid" name="end_date"
                   value="{{ isset($card) ? $card->end_date : old('end_date') }}">
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
