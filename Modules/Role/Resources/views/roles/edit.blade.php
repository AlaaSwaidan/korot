@extends('admin.layouts.master')

@section('title')
    تعديل صلاحية
@endsection

@section('page_header')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">الصلاحيات</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('admin.roles.index') }}" class="text-muted text-hover-primary">الصلاحيات</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">تعديل صلاحية</li>
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
                {!! Form::model($role, ['method' => 'PATCH', 'url' => route('admin.roles.update', $role->id),'class' => 'form-horizontal']) !!}
                @include('role::roles._form')
                {!! Form::close() !!}
            </div>
            <!--end::Card-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
@endsection
@section('scripts')
    <script>

        function checkAllModule(module_id) {

            if ($("#switch-all-" + module_id).is(':checked')) {

                $(".module_permissions_" + module_id).prop('checked', true);

            }else {

                $(".module_permissions_" + module_id).prop('checked', false);
            }
        }

        function checkAll() {

            if ($("#check_all").is(':checked')) {

                $(".for_check_all").prop('checked', true);

            }else {

                $(".for_check_all").prop('checked', false);
            }
        }

    </script>
@stop
