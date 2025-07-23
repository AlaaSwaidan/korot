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
                       value="{{ isset($admin) ? $admin->name : old('name') }}">
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
                       value="{{ isset($admin) ? $admin->email : old('email') }}">
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
                       value="{{ isset($admin) ? $admin->phone : old('phone') }}">
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
                <label class="fs-6 fw-semibold mt-2">مجموعات الإشراف</label>
                <!--end::Label-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-9">
                <!--begin::Input-->
                <select name="roles" aria-label="اختر المجموعة" data-hide-search="true" data-control="select2" data-placeholder="اختر المجموعة" class="form-select mb-2">
                    <option></option>
                    @foreach( $roles as $role)
                        <option value="{{ $role->id }}" {{ isset($admin) ? ($admin->roles[0]->id == $role->id ? "selected" : '') : (old("roles") == $role->id ? "selected" : "" ) }}>{{ $role->name }}</option>
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
                <label class="fs-6 fw-semibold">حالة العضوية</label>
                <!--end::Label-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-9">
                <!--begin::Switch-->
                <div class="form-check form-switch form-check-custom form-check-solid me-10">
                    <input class="form-check-input h-30px w-50px" name="status" type="checkbox" value="1" {{ isset($admin) ?( $admin->status ? "checked" : '') : '' }} id="autotimezone" />
                    <label class="form-check-label" for="autotimezone">مفعل</label>
                </div>
                <!--begin::Switch-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Input group-->
        @if( !isset($admin))
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
