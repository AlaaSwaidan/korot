<!--begin::Card body-->
<div class="card-body">
    <!--begin::Input group-->
    <div class="fv-row row mb-15">
        <!--begin::Col-->
        <div class="col-md-3">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold mt-2">{{ getUserType($type)  }}</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <select  aria-label="اختر {{ getUserType($type)  }}" data-hide-search="true" data-control="select2" data-placeholder="اختر {{ getUserType($type)  }}" multiple  id="user" name="user[]" class="form-select mb-2">
                <option value=""></option>
                @if($type == "users")  <option value="users">جميع العملاء</option> @endif
                @if($type == "distributors")  <option value="distributors">جميع الموزعين</option> @endif
                @if($type == "merchants")  <option value="merchants">جميع التجار</option> @endif
                @foreach( $data as $user)
                    <option value="{{ $user->id }}" >{{ $user->name}}</option>
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
                <label class="fs-6 fw-semibold">عنوان الرسالة(AR):</label>
                <!--end::Label-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-9">
                <!--begin::Input-->
                <input type="text"  class="form-control form-control-lg form-control-solid" name="title[ar]" placeholder="عنوان الرسالة(AR)"
                       value="">
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
                <label class="fs-6 fw-semibold">عنوان الرسالة(EN)::</label>
                <!--end::Label-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-9">
                <!--begin::Input-->
                <input type="text"  class="form-control form-control-lg form-control-solid" name="title[en]" placeholder="عنوان الرسالة(EN)"
                       value="">
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
                <label class="fs-6 fw-semibold">نص الرسالة(AR)::</label>
                <!--end::Label-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-9">
                <!--begin::Input-->
                <textarea id="message" name="message[ar]" class="form-control form-control-lg form-control-solid" rows="10" placeholder="نص الرسالة(AR)"></textarea>

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
                <label class="fs-6 fw-semibold">نص الرسالة(EN)::</label>
                <!--end::Label-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-9">
                <!--begin::Input-->
                <textarea id="message" name="message[en]" class="form-control form-control-lg form-control-solid" rows="10" placeholder="نص الرسالة(EN)"></textarea>

                <!--end::Input-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Input group-->

<input type="hidden" name="type" value="{{ $type }}">


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
