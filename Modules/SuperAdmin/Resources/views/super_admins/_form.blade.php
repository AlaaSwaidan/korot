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
                       value="{{ isset($superAdmin) ? $superAdmin->name : old('name') }}">
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
                       value="{{ isset($superAdmin) ? $superAdmin->email : old('email') }}">
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
                       value="{{ isset($superAdmin) ? $superAdmin->phone : old('phone') }}">
                <!--end::Input-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="fv-row row mb-15">
            <input type="hidden" name="roles" value="1">
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
                    <input class="form-check-input h-30px w-50px" name="status" type="checkbox" value="1" {{ isset($superAdmin) ?( $superAdmin->status ? "checked" : '') : '' }} id="autotimezone" />
                    <label class="form-check-label" for="autotimezone">مفعل</label>
                </div>
                <!--begin::Switch-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Input group-->
        @if( !isset($superAdmin))
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
