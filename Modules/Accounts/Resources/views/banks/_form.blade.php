
<!--begin::Card body-->
<div class="tab-pane fade show active" id="kt_table_widget_6_tab_1">
    <!--begin::Header-->
    <div class="card-header border-0 pt-5">
        <div class="card-toolbar">
            <ul class="nav">
                @foreach(siteLanguages() as $key => $language)
                    <li class="nav-item" @if($key == 'ar') role="presentation" @endif>
                        <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-secondary fw-bold px-4 me-1 {{ $key == 'ar' ? 'active' : '' }}" data-bs-toggle="tab" href="#tab_{{ $key }}" aria-selected="true" role="tab">{{ $language }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="card-body py-3">
        <div class="tab-content">
            @foreach(siteLanguages() as $key => $language)
                <div class="tab-pane {{ $key == 'ar' ? 'fade show active' : '' }}" id="tab_{{ $key }}">

                    <!--begin::Input group-->
                    <div class="fv-row row mb-15">
                        <!--begin::Col-->
                        <div class="col-md-3 d-flex align-items-center">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold">الاسم</label>
                            <!--end::Label-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-9">

                            {!! Form::text("name[$key]", isset($bank) ? $bank->name[$key] : null, ['class'=> 'form-control form-control-lg form-control-solid', 'placeholder'=> $language]) !!}

                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                </div>

            @endforeach
        </div>
    </div>

    <!--end::Header-->

</div>
<!--end::Card body-->
<!--begin::Tap pane-->
<div class="tab-pane fade" id="kt_table_widget_6_tab_2">
<!--begin::Card body-->
<div class="card-body">

    <!--begin::Input group-->
    <div class="fv-row row mb-15">
        <!--begin::Col-->
        <div class="col-md-3">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold mt-2">النوع</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <select name="type" aria-label="اختر النوع" data-hide-search="true" data-control="select2" data-placeholder="اختر النوع" class="form-select mb-2">
                <option></option>
                <option value="cash" {{ isset($bank) ? ($bank->type == "cash" ? 'selected' : '') : (old('type') == "cash" ? 'selected' : '') }}>كاش</option>
                <option value="bank" {{ isset($bank) ? ($bank->type == "bank" ? 'selected' : '') : (old('type') == "bank" ? 'selected' : '') }}>بنك</option>

            </select>
            <!--end::Input-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Input group-->
    <div id="account-number">
        @if(isset($bank) && $bank->type == "bank")
            <!--begin::Input group-->
            <div class="fv-row row mb-15">
                <!--begin::Col-->
                <div class="col-md-3 d-flex align-items-center">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold">رقم الحساب</label>
                    <!--end::Label-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-md-9">
                    <!--begin::Input-->
                    <input type="text"  class="form-control form-control-lg form-control-solid" name="account_number" placeholder="رقم الحساب"
                           value="{{ isset($bank) ? $bank->account_number : old('account_number') }}" >
                    <!--end::Input-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Input group-->
        @endif
    </div>


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
</div>
