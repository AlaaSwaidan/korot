@extends('admin.layouts.master')

@section('title')
    إضافة البنك
@endsection

@section('page_header')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">البنوك</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('admin.banks.index') }}" class="text-muted text-hover-primary">البنوك</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">إضافة البنك</li>
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
                {!! Form::open([ 'url' => route('admin.banks.store'), 'class' => 'form-horizontal' ,'files'=>'true' ]) !!}
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <div class="card-toolbar">
                        <ul class="nav">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-secondary fw-bold px-4 me-1 active" data-bs-toggle="tab" href="#kt_table_widget_6_tab_1" aria-selected="true" role="tab">عام</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-secondary fw-bold px-4 me-1" data-bs-toggle="tab" href="#kt_table_widget_6_tab_2">اخرى</a>
                            </li>

                        </ul>
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                    <div class="tab-content">
                        @include('accounts::banks._form')
                    </div>
                </div>
                <!--end::Body-->

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
        $( "body" ).on( "change", "select[name='type']", function() {
            var id = $(this).val();

            if(id === "bank"){
                $('#account-number').append('<div class="fv-row row mb-15"> <div class="col-md-3 d-flex align-items-center"> <label class="fs-6 fw-semibold">رقم الحساب</label> </div> ' +
                    '<div class="col-md-9"><input type="text"  class="form-control form-control-lg form-control-solid" name="account_number" placeholder="رقم الحساب" > </div> </div>');
            }else{
                $('#account-number').empty();
            }
        });
    </script>
@endsection
