<!--begin::Form-->
<form action="{{ route('admin.users-reports.search') }}">
    <!--begin::Card-->
    <div class="card mb-7" style="padding-bottom: 10px;">
        <!--begin::Card body-->
        <div class="card-body">
            <!--begin::Compact form-->
            <div class="d-flex align-items-center">
                <!--begin::Input group-->
                <div class="position-relative w-md-400px me-md-2">
                    <div class="row">
                        <!--begin::Col-->
                        <div class="col-lg-6">
                            <label class="fs-6 form-label fw-bold text-dark">الفترة الزمنية</label>
                            <!--begin::Select-->
                            <select class="form-select form-select-solid" name="time" data-control="select2" data-placeholder="الفترة الزمنية" data-hide-search="true">
                                <option value=""></option>
                                <option value="today" {{ isset($time) && $time == "today" ? 'selected' : '' }}>اليوم</option>
                                <option value="current_week" {{ isset($time) && $time == "current_week" ? 'selected' : '' }}>الاسبوع الحالي</option>
                                <option value="current_month" {{ isset($time) && $time == "current_month" ? 'selected' : '' }}>الشهر الحالي</option>
                                <option value="exact_time" {{ isset($time) && $time == "exact_time" ? 'selected' : '' }}>فترة محددة</option>
                            </select>
                            <!--end::Select-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-lg-6">
                            <label class="fs-6 form-label fw-bold text-dark">نوع المستخدم</label>
                            <!--begin::Select-->
                            <select class="form-select form-select-solid" name="user_type" data-control="select2" data-placeholder="نوع المستخدم" data-hide-search="true">
                                <option value="">الكل</option>
                                <option value="App\Models\Distributor" {{ isset($user_type) && $user_type == "App\Models\Distributor" ? 'selected' : '' }}>موزع</option>
                                <option value="App\Models\Merchant" {{ isset($user_type) && $user_type == "App\Models\Merchant" ? 'selected' : '' }}>تاجر</option>
                                <option value="App\Models\Admin" {{ isset($user_type) && $user_type == "App\Models\Admin" ? 'selected' : '' }}>مدير</option>
                            </select>
                            <!--end::Select-->
                        </div>
                        <!--end::Col-->
                        <div  class="col-lg-6" id="all-users">
                              @if(isset($user_type))
                                <label class="fs-6 form-label fw-bold text-dark">اختر المستخدم</label>
                                <!--begin::Select-->
                                <select class="form-select form-select-solid" name="username" data-control="select2" data-placeholder="نوع المستخدم" data-hide-search="false">
                                    <option value=""></option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ isset($username) && $username == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <!--end::Select-->
                              @endif
                        </div>
                    </div>
                    <input type="hidden" name="type" value="{{ $type }}">
                    <!--end::Col-->
                    <!--begin::Row-->
                    <div class="row g-8">
                        <!--begin::Col-->
                        <div id="from-div" style="@if(isset($from_date)) display: block; @else display: none; @endif" class="col-lg-6">
                            <label class="fs-6 form-label fw-bold text-dark">من</label>
                            <input type="date" class="form-control form-control form-control-solid" name="from_date" value="{{ isset($from_date) ? $from_date->format('Y-m-d') : null }}" />
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div id="to-div" style="@if(isset($to_date)) display: block; @else display: none; @endif" class="col-lg-6">
                            <label class="fs-6 form-label fw-bold text-dark">الى</label>
                            <input type="date" class="form-control form-control form-control-solid" name="to_date" value="{{ isset($to_date) ? $to_date->format('Y-m-d') : null }}" />

                        </div>
                        <!--end::Col-->

                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Input group-->
                <!--begin:Action-->

                <div class="d-flex" style="margin-top: 53px">
                    <button type="submit" class="btn btn-primary me-5 disabledbutton">بحث</button>
                </div>

                <!--end:Action-->
            </div>
            <!--end::Compact form-->

        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
</form>
<!--end::Form-->


