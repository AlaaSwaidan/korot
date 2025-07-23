@extends('admin.layouts.master')

@section('title')
    تغيير كلمة المرور
@endsection

@section('page_header')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">مدير النظام</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('admin.super-admins.index') }}" class="text-muted text-hover-primary">مدير النظام</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">تغيير كلمة المرور</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->

        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->
@endsection

@section('content')
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Card-->
            <div class="card card-flush">
                {!! Form::open([ 'url' => route('admin.super-admins.post.change-password', $superAdmin), 'class' => 'form-horizontal' ]) !!}
                <!--begin::Card body-->
                <div class="card-body">
                    <!--begin::Form-->
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
                                    <input type="password"  class="form-control form-control-lg form-control-solid" name="new_password" placeholder="كلمة المرور"
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
                    <!--end::Form-->
                </div>
                <!--end::Card body-->


                {!! Form::close() !!}
            </div>
            <!--end::Card-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
@endsection
