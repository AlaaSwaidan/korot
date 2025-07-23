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

                            {!! Form::text("name[$key]", isset($setting) ? $setting->name[$key] : null, ['class'=> 'form-control form-control-lg form-control-solid', 'placeholder'=> $language]) !!}

                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row row mb-15">
                        <!--begin::Col-->
                        <div class="col-md-3 d-flex align-items-center">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold">اسم البنك</label>
                            <!--end::Label-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-9">

                            {!! Form::text("bank_name[$key]", isset($setting) ? $setting->bank_name[$key] : null, ['class'=> 'form-control form-control-lg form-control-solid', 'placeholder'=> $language]) !!}

                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row row mb-15">
                        <!--begin::Col-->
                        <div class="col-md-3 d-flex align-items-center">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold">عنوان البنك</label>
                            <!--end::Label-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-9">

                            {!! Form::text("bank_address[$key]", isset($setting) ? $setting->bank_address[$key] : null, ['class'=> 'form-control form-control-lg form-control-solid', 'placeholder'=> $language]) !!}

                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row row mb-15">
                        <!--begin::Col-->
                        <div class="col-md-3 d-flex align-items-center">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold">الشروط والأحكام</label>
                            <!--end::Label-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-9">

                            {!! Form::textarea("terms[$key]", isset($setting) ? $setting->terms[$key] : null, ['class'=> 'form-control form-control-lg form-control-solid', 'placeholder'=> $language]) !!}

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
    <!--begin::Input group-->
    <div class="fv-row row mb-15">
        <!--begin::Col-->
        <div class="col-md-3 d-flex align-items-center">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold">البريد الالكتروني</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"  class="form-control form-control-lg form-control-solid" name="email" placeholder="البريد الالكتروني"
                   value="{{ isset($setting) ? $setting->email : old('email') }}">
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
            <label class="fs-6 fw-semibold">رقم الجوال</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"  class="form-control form-control-lg form-control-solid" name="phone" placeholder="رقم الجوال"
                   value="{{ isset($setting) ? $setting->phone : old('phone') }}">
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
            <label class="fs-6 fw-semibold">رقم الحساب (البنك)</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"  class="form-control form-control-lg form-control-solid" name="account_number" placeholder="رقم الحساب"
                   value="{{ isset($setting) ? $setting->account_number : old('account_number') }}">
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
            <label class="fs-6 fw-semibold">كود البنك</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"  class="form-control form-control-lg form-control-solid" name="bank_code" placeholder="كود البنك"
                   value="{{ isset($setting) ? $setting->bank_code : old('bank_code') }}">
            <!--end::Input-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Input group-->
    <hr>
    <h2>العمليات للتجار اعلي مبيعا</h2>
    <!--begin::Input group-->
    <div class="fv-row row mb-15">
        <!--begin::Col-->
        <div class="col-md-3 d-flex align-items-center">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold">عدد المبيعات للتجار الأعلى مبيعا</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="number" min="1"  class="form-control form-control-lg form-control-solid" name="transaction_count" placeholder="عدد المبيعات للتجار الأعلى مبيعا"
                   value="{{ isset($setting) ? $setting->transaction_count : old('transaction_count') }}">
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
            <label class="fs-6 fw-semibold">عدد الأيام</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="number" min="1"  class="form-control form-control-lg form-control-solid" name="transaction_days" placeholder="عدد الأيام"
                   value="{{ isset($setting) ? $setting->transaction_days : old('transaction_days') }}">
            <!--end::Input-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Input group-->
    <hr>
    <h2>العمليات للتجار الأقل مبيعا</h2>
    <!--begin::Input group-->
    <div class="fv-row row mb-15">
        <!--begin::Col-->
        <div class="col-md-3 d-flex align-items-center">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold">عدد المبيعات للتجار الأقل مبيعا</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="number" min="1"  class="form-control form-control-lg form-control-solid" name="transaction_lowest_count" placeholder="عدد المبيعات للتجار الأقل مبيعا"
                   value="{{ isset($setting) ? $setting->transaction_lowest_count : old('transaction_lowest_count') }}">
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
            <label class="fs-6 fw-semibold">عدد الأيام</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="number" min="1"  class="form-control form-control-lg form-control-solid" name="transaction_lowest_day" placeholder="عدد الأيام"
                   value="{{ isset($setting) ? $setting->transaction_lowest_day : old('transaction_lowest_day') }}">
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
            <label class="fs-6 fw-semibold">
                عمولة جيديا
                <p style="color: #8f3938">ex:0.008</p>
            </label>

            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"   class="form-control form-control-lg form-control-solid" name="geidea_percentage" placeholder="عمولة جيديا"
                   value="{{ isset($setting) ? $setting->geidea_percentage : old('geidea_percentage') }}">
            <!--end::Input-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Input group-->
    <hr>
    <h2>نسخه التطبيق</h2>
    <!--begin::Input group-->
    <div class="fv-row row mb-15">
        <!--begin::Col-->
        <div class="col-md-3 d-flex align-items-center">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold">
                النسخه الحالية
            </label>

            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"   class="form-control form-control-lg form-control-solid" name="current_version" placeholder="النسخه الحالية"
                   value="{{ isset($setting) ? $setting->current_version : old('current_version') }}">
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
            <label class="fs-6 fw-semibold">
                تاريخ اصدار النسخه الحالية
            </label>

            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="date"   class="form-control form-control-lg form-control-solid" name="version_date" placeholder="تاريخ اصدار النسخه الحالية"
                   value="{{ isset($setting) ? $setting->version_date : old('version_date') }}">
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
            <label class="fs-6 fw-semibold">
              رابط النسخة الحالية
            </label>

            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"   class="form-control form-control-lg form-control-solid" name="version_apk_link" placeholder="  رابط النسخة الحالية"
                   value="{{ isset($setting) ? $setting->version_apk_link : old('version_apk_link') }}">
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
            <label class="fs-6 fw-semibold">حالة النسخة</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Switch-->
            <div class="form-check form-switch form-check-custom form-check-solid me-10">
                <input class="form-check-input h-30px w-50px" name="version_status" type="checkbox" value="1" {{ isset($setting) ?( $setting->version_status ? "checked" : '') : '' }} id="autotimezone" />
                <label class="form-check-label" for="autotimezone">مفعل</label>
            </div>
            <!--begin::Switch-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Input group-->
    <hr>
    <h2>نسخه التطبيق الموزع</h2>
    <!--begin::Input group-->
    <div class="fv-row row mb-15">
        <!--begin::Col-->
        <div class="col-md-3 d-flex align-items-center">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold">
                النسخه الحالية
            </label>

            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"   class="form-control form-control-lg form-control-solid" name="distributor_current_version" placeholder="النسخه الحالية"
                   value="{{ isset($setting) ? $setting->distributor_current_version : old('distributor_current_version') }}">
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
            <label class="fs-6 fw-semibold">
                تاريخ اصدار النسخه الحالية
            </label>

            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="date"   class="form-control form-control-lg form-control-solid" name="distributor_version_date" placeholder="تاريخ اصدار النسخه الحالية"
                   value="{{ isset($setting) ? $setting->distributor_version_date : old('distributor_version_date') }}">
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
            <label class="fs-6 fw-semibold">
              رابط النسخة الحالية
            </label>

            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"   class="form-control form-control-lg form-control-solid" name="distributor_version_apk_link" placeholder="  رابط النسخة الحالية"
                   value="{{ isset($setting) ? $setting->distributor_version_apk_link : old('distributor_version_apk_link') }}">
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
            <label class="fs-6 fw-semibold">حالة النسخة</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Switch-->
            <div class="form-check form-switch form-check-custom form-check-solid me-10">
                <input class="form-check-input h-30px w-50px" name="distributor_version_status" type="checkbox" value="1" {{ isset($setting) ?( $setting->distributor_version_status ? "checked" : '') : '' }} id="autotimezone" />
                <label class="form-check-label" for="autotimezone">مفعل</label>
            </div>
            <!--begin::Switch-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Input group-->
    <h2>نظام تحت الصيانة</h2>
    <!--begin::Input group-->
    <div class="fv-row row mb-15">
        <!--begin::Col-->
        <div class="col-md-3 d-flex align-items-center">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold">تفعيل نظام تحت الصيانة </label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Switch-->
            <div class="form-check form-switch form-check-custom form-check-solid me-10">
                <input class="form-check-input h-30px w-50px" name="shutdown_app" type="checkbox" value="1" {{ isset($setting) ?( $setting->shutdown_app ? "checked" : '') : '' }} id="autotimezone" />
                <label class="form-check-label" for="autotimezone">مفعل</label>
            </div>
            <!--begin::Switch-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Input group-->
</div>
<!--end::Tap pane-->

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
