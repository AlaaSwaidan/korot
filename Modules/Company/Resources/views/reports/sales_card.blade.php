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
            @include('company::reports.search_sales_form')

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

                        <!--begin::Table row-->
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                            <th >#</th>
                            <th >الفئة</th>
                            <th > عدد مبيعات اليوم</th>
                            <th >عدد مبيعات الاسبوع</th>
                            <th >عدد مبيعات الشهر</th>
                            <th >اجمالي مبيعات اليوم</th>
                            <th >المتبقي</th>


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
                                    <div class="badge badge-light-info">  {{ $value->sold_per_day }}</div>
                                </td>
                                <td>
                                    <div class="badge badge-light-info">  {{ $value->sold_per_week }}</div>
                                </td>
                                <td>
                                    <div class="badge badge-light-info">  {{ $value->sold_per_week }}</div>
                                </td>
                                <td>
                                    <div class="badge badge-light-info">  {{ $value->total_card_price . $value->updated_at }}</div>
                                </td>
                                <td>
                                    <div class="badge badge-light-info">  {{ $value->total_unsold }}</div>
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
