@extends('admin.layouts.master')

@section('title')
    تقارير البطاقات
@endsection
@section('styles')



@endsection
@section('page_header')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">تقارير البطاقات</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('admin.home') }}" class="text-muted text-hover-primary">الرئيسية</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">تقارير البطاقات</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
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
            @include('company::reports.search_form')
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                <!--begin::Col-->
                <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10" >
                    <!--begin::Card widget 20-->
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10" style="background-color: #483c99;background-image:url('assets/media/patterns/vector-1.png');height:90% !important;">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">
                                <!--begin::Amount-->
                                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $imported_count + $duplicated_count }}</span>
                                <!--end::Amount-->
                                <!--begin::Subtitle-->
                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">اجمالي تقارير البطاقات المدخلة</span>
                                <!--end::Subtitle-->
                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Header-->
                    </div>
                    <!--end::Card widget 20-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10"  onclick='window.location.href="{{ $url }}"'>
                    <!--begin::Card widget 20-->
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10" style="background-color: #2a8231;background-image:url('assets/media/patterns/vector-1.png');height:90% !important;">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">
                                <!--begin::Amount-->
                                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $duplicated_count }}</span>
                                <!--end::Amount-->
                                <!--begin::Subtitle-->
                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">اجمالي تقارير البطاقات المكررة</span>
                                <!--end::Subtitle-->
                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Header-->
                    </div>
                    <!--end::Card widget 20-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                    <!--begin::Card widget 20-->
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10" style="background-color: #a13f0a;background-image:url('assets/media/patterns/vector-1.png');height:90% !important;">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">
                                <!--begin::Amount-->
                                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $imported_count }}</span>
                                <!--end::Amount-->
                                <!--begin::Subtitle-->
                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">اجمالي تقارير البطاقات الفريدة</span>
                                <!--end::Subtitle-->
                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Header-->
                    </div>
                    <!--end::Card widget 20-->
                </div>
                <!--end::Col-->
                <form action="{{route('admin.reports.cards-reports-excel')}}" method="post" >
                    @csrf

                    <button type="submit"  class="btn btn-success disabledbutton">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                        <i class="fas fa-file-excel"></i>
                        <!--end::Svg Icon-->
                    </button>
                    <input type="hidden" name="category_id" value="{{ isset($category_id)? $category_id : null }}">
                    <input type="hidden" name="package_id" value="{{ isset($package_id)? $package_id : null }}">
                    <input type="hidden" name="company_id" value="{{ isset($company_id)? $company_id : null }}">
                    <input type="hidden" name="from_date" value="{{ isset($from_date)? $from_date : null }}">
                    <input type="hidden" name="to_date" value="{{ isset($to_date)? $to_date : null }}">
                </form>
            </div>
            <!--end::Row-->
        </div>
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Card-->
            <div class="card">

                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_subscriptions_table">
                        <!--begin::Table head-->
                        <thead>
                        <tr>
                            <td colspan="1"  class="border-right-0 border-bottom-0 border-top-0"></td>
                            <td>
                                الاجمالي
                            </td>
                            <td>
                                {{ $imported_count }}
                            </td>
                            <td>
                                {{ number_format($data->sum('total_cost'),2) }}
                            </td>
                        </tr>
                        <!--begin::Table row-->
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                            <th >#</th>
                            <th >الفئة</th>
                            <th >العدد</th>
                            <th >مجموع التكلفة</th>


                        </tr>
                        <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="text-gray-600 fw-semibold">
                        <?php $i = 0; ?>
                        @foreach($data as $value )
                                <?php ++$i; ?>
                            <tr>

                                <td> {{ $i }} </td>

                                <td>
                                    <div class="badge badge-light-info">  {{  $value->full_name }}</div>
                                </td>
                                <td>
                                    <div class="badge badge-light-info">  {{ $value->total_cards }}</div>
                                </td>
                                <td>
                                    <div class="badge badge-light-info">  {{ number_format($value->total_cost,2) }}</div>
                                </td>

                            </tr>
                        @endforeach

                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Content container-->
        <!--end::Content container-->
    </div>
    <!--end::Content-->

@endsection
@section('scripts')
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="{{ URL::asset('admin/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <!--end::Vendors Javascript-->
    <script src="{{ URL::asset('admin/assets/js/custom/apps/subscriptions/list/list.js') }}"></script>

    <!--begin::Vendors Javascript(used for this page only)-->
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    {{--    <script src="{{ URL::asset('admin/assets/js/custom/apps/subscriptions/list/list.js') }}"></script>--}}
    <script src="{{ URL::asset('admin/assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ URL::asset('admin/assets/js/custom/widgets.js') }}"></script>
    <script src="{{ URL::asset('admin/assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ URL::asset('admin/assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
    <script src="{{ URL::asset('admin/assets/js/custom/utilities/modals/create-app.js') }}"></script>
    <script src="{{ URL::asset('admin/assets/js/custom/utilities/modals/users-search.js') }}"></script>
    <script src="{{ URL::asset('admin/assets/js/custom/utilities/modals/create-project/settings.js') }}"></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->


    <script>
        $( "body" ).on( "change", "select[name='company_id']", function() {
            var id = $(this).val();
            if(id ){
                $('#all-categories').empty();
                $.ajax({
                    url: '/admin/get/all-categories/'+id,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {

                        if (data['categories'].length > 0) {

                            $('#all-categories').append('  <select class="form-select form-select-solid" id="category_id" name="category_id" data-control="select2" data-placeholder="الفئات" data-hide-search="false"><option value="">اختر</option>');


                            $.each(data['categories'], function (index, categories) {


                                $('select[name="category_id"]').append('<option  value="' + categories.id + '">' + categories.name_ar + '</option>');


                            });
                            $('#all-categories').append(' </select>');
                            $("#category_id").select2();


                        }


                    }
                });

            }

            else{
                $('#all-categories').empty();
            }


        });
        $( "body" ).on( "change", "select[name='category_id']", function() {
            var id = $(this).val();
            if(id ){
                $('#all-packages').empty();
                $.ajax({
                    url: '/admin/get/all-imported-packages/'+id,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {

                        if (data['packages'].length > 0) {

                            $('#all-packages').append('  <select class="form-select form-select-solid" id="package_id" name="package_id" data-control="select2" data-placeholder="الفئات" data-hide-search="false"><option value="">اختر</option>');


                            $.each(data['packages'], function (index, packages) {


                                $('select[name="package_id"]').append('<option  value="' + packages.id + '">' + packages.name_ar + '</option>');


                            });
                            $('#all-packages').append(' </select>');
                            $("#package_id").select2();


                        }


                    }
                });

            }

            else{
                $('#all-packages').empty();
            }


        });

    </script>


@endsection
