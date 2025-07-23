
<!--begin::Tap pane-->
<!--begin::Card body-->
<div class="card-body">
    <!--begin::Input group-->
    <div class="fv-row row mb-15">
        <!--begin::Col-->
        <div class="col-md-3 d-flex align-items-center">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold">اسم الشركة</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"  class="form-control form-control-lg form-control-solid" name="company_name" placeholder="اسم الشركة"
                   value="{{ isset($outgoing) ? $outgoing->company_name : old('company_name') }}">
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
            <label class="fs-6 fw-semibold">التاريخ</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="date"  class="form-control form-control-lg form-control-solid" name="date" placeholder="التاريخ"
                   value="{{ isset($outgoing) ? $outgoing->date : old('date') }}">
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
            <label class="fs-6 fw-semibold">الرقم الضريبي</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"  class="form-control form-control-lg form-control-solid" name="tax_number" placeholder="الرقم الضريبي"
                   value="{{ isset($outgoing) ? $outgoing->tax_number : old('tax_number') }}">
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
            <label class="fs-6 fw-semibold">المبلغ</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"  class="form-control form-control-lg form-control-solid" name="amount" placeholder="المبلغ"
                   value="{{ isset($outgoing) ? $outgoing->amount : old('amount') }}">
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
            <label class="fs-6 fw-semibold">نسبة الصريبة</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"  class="form-control form-control-lg form-control-solid" name="tax" placeholder="نسبة الصريبة"
                   value="{{ isset($outgoing) ? $outgoing->tax : old('tax') }}">
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
            <label class="fs-6 fw-semibold">الكمية</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"  class="form-control form-control-lg form-control-solid" name="quantity" placeholder="الكمية"
                   value="{{ isset($outgoing) ? $outgoing->quantity : old('quantity') }}">
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
            <label class="fs-6 fw-semibold">نسبة الخصم %</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"  class="form-control form-control-lg form-control-solid" name="discount" placeholder="نسبة الخصم %"
                   value="{{ isset($outgoing) ? $outgoing->discount : old('discount') }}">
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
            <label class="fs-6 fw-semibold mt-2">نوع الدفع</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <select name="payment_method" aria-label="اختر النوع" data-hide-search="true" data-control="select2" data-placeholder="اختر النوع" class="form-select mb-2">
                <option></option>
                <option value="cash" {{ isset($outgoing) ? ($outgoing->payment_method == "cash" ? 'selected' : '') : (old('payment_method') == "cash" ? 'selected' : '') }}>كاش</option>
                <option value="bank" {{ isset($outgoing) ? ($outgoing->payment_method == "bank" ? 'selected' : '') : (old('payment_method') == "bank" ? 'selected' : '') }}>بنك</option>
                <option value="check" {{ isset($outgoing) ? ($outgoing->payment_method == "check" ? 'selected' : '') : (old('payment_method') == "check" ? 'selected' : '') }}>شيك</option>

            </select>
            <!--end::Input-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Input group-->
    <div id="banks">
        @if(isset($outgoing))
            <!--begin::Input group-->
            <div class="fv-row row mb-15">
                <!--begin::Col-->
                <div class="col-md-3">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold mt-2">{{ $outgoing->payment_method == "cash" ? "الخزن" : "البنوك" }}</label>
                    <!--end::Label-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-md-9">
                    <!--begin::Input-->
                    <select name="bank_id" aria-label="اختر " data-hide-search="true" data-control="select2" data-placeholder="اختر " class="form-select mb-2">
                        <option></option>
                        @foreach($banks as $bank)
                            <option value="{{ $bank->id }}" {{ $bank->id == $outgoing->bank_id ? 'selected' : ''}}>{{ $bank->name['ar'] }}</option>
                        @endforeach

                    </select>
                    <!--end::Input-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Input group-->
        @endif
    </div>
    <!--begin::Input group-->
    <div class="fv-row row mb-15">
        <!--begin::Col-->
        <div class="col-md-3 d-flex align-items-center">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold">الملاحظات</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"  class="form-control form-control-lg form-control-solid" name="notes" placeholder="الملاحظات"
                   value="{{ isset($outgoing) ? $outgoing->notes : old('notes') }}">
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
                    <span class="indicator-label">تأكيد</span>

                </button>
                <!--end::Button-->
            </div>
        </div>
        <!--begin::Action buttons-->

</div>
<!--end::Card body-->
