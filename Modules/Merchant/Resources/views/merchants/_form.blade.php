<!--begin::Card body-->
<div class="card-body">
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
                <!--begin::Input-->
                <input type="text"  class="form-control form-control-lg form-control-solid" name="name" placeholder="الاسم"
                       value="{{ isset($merchant) ? $merchant->name : old('name') }}">
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
                <label class="fs-6 fw-semibold">اسم العلامة التجارية</label>
                <!--end::Label-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-9">
                <!--begin::Input-->
                <input type="text"  class="form-control form-control-lg form-control-solid" name="brand_name" placeholder="اسم العلامة التجارية"
                       value="{{ isset($merchant) ? $merchant->brand_name : old('brand_name') }}">
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
                <label class="fs-6 fw-semibold">البريد الالكتروني</label>
                <!--end::Label-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-9">
                <!--begin::Input-->
                <input type="text"  class="form-control form-control-lg form-control-solid" name="email" placeholder="البريد الالكتروني"
                       value="{{ isset($merchant) ? $merchant->email : old('email') }}">
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
                       value="{{ isset($merchant) ? $merchant->phone : old('phone') }}">
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
                <label class="fs-6 fw-semibold">رقم الضريبي</label>
                <!--end::Label-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-9">
                <!--begin::Input-->
                <input type="text"  class="form-control form-control-lg form-control-solid" name="tax_number" placeholder="رقم الضريبي"
                       value="{{ isset($merchant) ? $merchant->tax_number : old('tax_number') }}">
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
                <label class="fs-6 fw-semibold">السجل التجاري</label>
                <!--end::Label-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-9">
                <!--begin::Input-->
                <input type="text"  class="form-control form-control-lg form-control-solid" name="commercial_number" placeholder="السجل التجاري"
                       value="{{ isset($merchant) ? $merchant->commercial_number : old('tax_number') }}">
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
                <label class="fs-6 fw-semibold">رقم الماكينة</label>
                <!--end::Label-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-9">
                <!--begin::Input-->
                <input type="text"  class="form-control form-control-lg form-control-solid" name="machine_number" placeholder="رقم الماكينة"
                       value="{{ isset($merchant) ? $merchant->machine_number : old('machine_number') }}">
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
                <label class="fs-6 fw-semibold">العنوان</label>
                <!--end::Label-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-9">
                <!--begin::Input-->
                <input type="text"  class="form-control form-control-lg form-control-solid" name="location" placeholder="العنوان"
                       value="{{ isset($merchant) ? $merchant->location : old('location') }}">
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
            <label class="fs-6 fw-semibold mt-2">النوع</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <select name="type" aria-label="اختر النوع" data-hide-search="true" data-control="select2" data-placeholder="اختر النوع" class="form-select mb-2">
                <option></option>
                @foreach(cardsType() as $key => $value)
                    <option value="{{ $key }}" {{ isset($merchant) ? ($merchant->type == $key ? 'selected' : '') : (old('type') == $key ? 'selected' : '') }}>
                        {{ $value }}</option>

                @endforeach

            </select>
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
                <label class="fs-6 fw-semibold">الصورة </label>
                <!--end::Label-->
            </div>
            <!--end::Col-->
            <!--begin::Image input-->
            <div class="col-md-9">
            <div class="image-input image-input-outline image-input-placeholder" data-kt-image-input="true">
                <!--begin::Preview existing avatar-->
                <div class="image-input-wrapper w-125px h-125px" @if(isset($merchant)) style="background-image: url({{ $merchant->image_full_path }});" @endif></div>
                <!--end::Preview existing avatar-->
                <!--begin::Label-->
                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                    <i class="bi bi-pencil-fill fs-7"></i>
                    <!--begin::Inputs-->
                    <input type="file" name="photo" accept=".png, .jpg, .jpeg" />
                    <input type="hidden" name="avatar_remove" />
                    <!--end::Inputs-->
                </label>
                <!--end::Label-->
                <!--begin::Cancel-->
                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                    <i class="bi bi-x fs-2"></i>
                </span>
                <!--end::Cancel-->
                <!--begin::Remove-->
                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                    <i class="bi bi-x fs-2"></i>
                </span>
                <!--end::Remove-->
            </div>
            </div>
            <!--end::Image input-->
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
            <input type="text"  class="form-control form-control-lg form-control-solid" name="geidea_percentage" placeholder="عمولة جيديا"
                   value="{{ isset($merchant) ? $merchant->geidea_percentage : old('geidea_percentage') }}">
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
                المنطقة
            </label>

            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"  class="form-control form-control-lg form-control-solid" name="region_id" placeholder="المنطقة"
                   value="{{ isset($merchant) ? $merchant->region_id : old('region_id') }}">
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
            <label class="fs-6 fw-semibold mt-2">المدن</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <select name="city_id" aria-label="اختر المدينة" data-hide-search="true" data-control="select2" data-placeholder="اختر المدينة" class="form-select mb-2">
                <option></option>
               @foreach($cities as $city)
                    <option value="{{ $city->id }}" {{ isset($merchant) ? ($merchant->city_id ==  $city->id ? 'selected' : '') : (old('city_id') == $city->id ? 'selected' : '') }}>{{ $city->name_ar }}</option>

                @endforeach

            </select>
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
                الشارع
            </label>

            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"  class="form-control form-control-lg form-control-solid" name="street" placeholder="الشارع"
                   value="{{ isset($merchant) ? $merchant->street : old('street') }}">
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
                منطقة مميزة(معلم)
            </label>

            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"  class="form-control form-control-lg form-control-solid" name="distinct" placeholder="منطقة مميزة(معلم)"
                   value="{{ isset($merchant) ? $merchant->distinct : old('distinct') }}">
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
                zipcode
            </label>

            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"  class="form-control form-control-lg form-control-solid" name="zipcode" placeholder="zipcode"
                   value="{{ isset($merchant) ? $merchant->zipcode : old('zipcode') }}">
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
                رقم المبنى
            </label>

            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"  class="form-control form-control-lg form-control-solid" name="building_number" placeholder="رقم المبنى"
                   value="{{ isset($merchant) ? $merchant->building_number : old('building_number') }}">
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
                رقم اضافي
            </label>

            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"  class="form-control form-control-lg form-control-solid" name="extra_number" placeholder="رقم اضافي"
                   value="{{ isset($merchant) ? $merchant->extra_number : old('extra_number') }}">
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
                <label class="fs-6 fw-semibold">حالة العضوية</label>
                <!--end::Label-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-9">
                <!--begin::Switch-->
                <div class="form-check form-switch form-check-custom form-check-solid me-10">
                    <input class="form-check-input h-30px w-50px" name="status" type="checkbox" value="1" {{ isset($merchant) ?( $merchant->active ? "checked" : '') : '' }} id="autotimezone" />
                    <label class="form-check-label" for="autotimezone">مفعل</label>
                </div>
                <!--begin::Switch-->
            </div>
            <!--end::Col-->
        </div>
        <!--begin::Input group-->
        <div class="fv-row row mb-15">
            <!--begin::Col-->
            <div class="col-md-3 d-flex align-items-center">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold">شحن المحفظة بمدى</label>
                <!--end::Label-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-9">
                <!--begin::Switch-->
                <div class="form-check form-switch form-check-custom form-check-solid me-10">
                    <input class="form-check-input h-30px w-50px" name="mada_pay" type="checkbox" value="1" {{ isset($merchant) ?( $merchant->mada_pay ? "checked" : '') : '' }} id="autotimezone" />
                    <label class="form-check-label" for="autotimezone">مفعل</label>
                </div>
                <!--begin::Switch-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Input group-->
        @if( !isset($merchant))
            <!--begin::Input group-->
            <div class="fv-row row mb-15">
                <!--begin::Col-->
                <div class="col-md-3 d-flex align-items-center">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold">كلمة المرور</label>
                    <!--end::Label-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-md-9">
                    <!--begin::Input-->
                    <input type="password"  class="form-control form-control-lg form-control-solid" name="password" placeholder="كلمة المرور"
                          >
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
                    <label class="fs-6 fw-semibold">تأكيد كلمة المرور</label>
                    <!--end::Label-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-md-9">
                    <!--begin::Input-->
                    <input type="password"  class="form-control form-control-lg form-control-solid" name="password_confirm" placeholder="تأكيد كلمة المرور"
                          >
                    <!--end::Input-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Input group-->
        @endif
        @if( isset($merchant) && $merchant->id == 632)
            <!--begin::Input group-->
            <div class="fv-row row mb-15">
                <!--begin::Col-->
                <div class="col-md-3 d-flex align-items-center">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold">كلمة المرور</label>
                    <!--end::Label-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-md-9">
                    <!--begin::Input-->
                    <input type="password"  class="form-control form-control-lg form-control-solid" name="password" placeholder="كلمة المرور"
                          >
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
                    <label class="fs-6 fw-semibold">تأكيد كلمة المرور</label>
                    <!--end::Label-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-md-9">
                    <!--begin::Input-->
                    <input type="password"  class="form-control form-control-lg form-control-solid" name="password_confirm" placeholder="تأكيد كلمة المرور"
                          >
                    <!--end::Input-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Input group-->
        @endif

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
