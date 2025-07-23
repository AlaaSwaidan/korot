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
                   value="{{ isset($distributor) ? $distributor->amount : old('amount') }}">
            <!--end::Input-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row row mb-15">
        <!--begin::Col-->
        <div class="col-md-3">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold mt-2">نوع التحصيل</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <select name="collection_type" aria-label="اختر النوع" data-hide-search="true" data-control="select2" data-placeholder="اختر النوع" class="form-select mb-2">
                <option></option>
                <option value="bank" {{  (old('collection_type') == "bank" ? 'selected' : '') }}>بنك</option>
                <option value="cash" {{  (old('collection_type') == "cash" ? 'selected' : '') }}>نقدي</option>
                <option value="check" {{  (old('collection_type') == "check" ? 'selected' : '') }}>شيك</option>
            </select>
            <!--end::Input-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Input group-->
    <div id="banks">


    </div>
    <!--begin::Input group-->
    <div class="fv-row row mb-15">
        <!--begin::Col-->
        <div class="col-md-3 d-flex align-items-center">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold">تفاصيل اخرى</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"  class="form-control form-control-lg form-control-solid" name="collection_description" placeholder="تفاصيل اخرى"
                   value="{{ isset($distributor) ? $distributor->collection_description : old('collection_description') }}">
            <div class="fs-7 text-muted">أكتب اسم البنك اذا كان بنك أو رقم الشيك أو أي تفاصيل أخرى</div>
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
