@extends('admin.layouts.master')

@section('title')
    إضافة تحصيل
@endsection

@section('page_header')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">التحصيل </h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.collections.index','type=distributors') }}" class="text-muted text-hover-primary">تحصيلات الموزعين</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">إضافة تحصيل للموزع {{ $distributor->name }}</li>
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
                {!! Form::open([ 'url' => route('admin.collections.store-collection-distributors',$distributor), 'class' => 'form-horizontal'  ]) !!}
                @include('collections::collections_distributors._form')
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
        $( "body" ).on( "change", "select[name='collection_type']", function() {
            var id = $(this).val();
            if(id === "bank" || id === "check"){
                $('#banks').empty();
                $.ajax({
                    url: '/admin/get/all-only-banks',
                    type: "GET",
                    dataType: "json",
                    success: function (data) {

                        if (data['banks'].length > 0) {

                            $('#banks').append('<div class="fv-row row mb-15"> <div class="col-md-3"> <label class="fs-6 fw-semibold mt-2">البنوك</label></div>' +
                                ' <div class="col-md-9"><select name="bank_name" aria-label="اختر " data-hide-search="true" data-control="select2" data-placeholder="اختر " class="form-select mb-2">');


                            $.each(data['banks'], function (index, banks) {


                                $('select[name="bank_name"]').append('<option  value="' + banks.id + '">' + banks.name_ar + '</option>');


                            });
                            $('#banks').append(' </select></div></div>');


                        }


                    }
                });
            }
            else if(id === "cash"){
                $('#banks').empty();
                $.ajax({
                    url: '/admin/get/all-stores',
                    type: "GET",
                    dataType: "json",
                    success: function (data) {

                        if (data['banks'].length > 0) {

                            $('#banks').append('<div class="fv-row row mb-15"> <div class="col-md-3"> <label class="fs-6 fw-semibold mt-2">الخزن</label></div>' +
                                ' <div class="col-md-9"><select name="bank_name" aria-label="اختر " data-hide-search="true" data-control="select2" data-placeholder="اختر " class="form-select mb-2">');


                            $.each(data['banks'], function (index, banks) {


                                $('select[name="bank_name"]').append('<option  value="' + banks.id + '">' + banks.name_ar + '</option>');


                            });
                            $('#banks').append(' </select></div></div>');


                        }


                    }
                });
            }
            else{
                $('#banks').empty();
            }


        });
    </script>
@endsection
