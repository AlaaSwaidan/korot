@extends('admin.layouts.master')

@section('title')
    تقرير مجمع
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
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">تقرير {{ getProcessType($type) }}
                </h1>
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
                    <li class="breadcrumb-item text-muted">تقرير {{ getProcessType($type) }}  </li>
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
            @include('reports::search.search_form')

            <!--begin::Card-->
            @if(isset($data))
                <!--begin::Card body-->
                <div class="card-body pt-0">

                    <h4> الاجمالي {{ getProcessType($type) }}
                     @if($total)
                            <div class="badge badge-secondary">  {{   $total . ' ريال '  }} </div>
                        @endif
                    </h4>
                    <br>

                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_subscriptions_table">
                        <!--begin::Table head-->
                        <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                            <th ></th>
                            <th >الاسم</th>
                            <th >النوع</th>
                            <th >البريد الالكتروني</th>
                            <th >رقم الجوال</th>
                            <th >{{ getProcessType($type) }}</th>
                            <th >تاريخ العملية</th>
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

                                <!--begin::Customer=-->
                                <td class="d-flex align-items-center">
                                    <!--begin:: Avatar -->
                                    @if(getUserModel($value->userable_type,$value->userable_id)->image)
                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                            <a href="{{ getUserModel($value->userable_type,$value->userable_id)->image_full_path }}">
                                                <div class="symbol-label">
                                                    <img src="{{ getUserModel($value->userable_type,$value->userable_id)->image_full_path }}" alt="{{ getUserModel($value->userable_type,$value->userable_id)->name }}" class="w-100">
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                    <!--end::Avatar-->
                                    <!--begin::User details-->
                                    <div class="d-flex flex-column">
                                      {{ getUserModel($value->userable_type,$value->userable_id)->name }}
                                        <span>{{ getUserModel($value->userable_type,$value->userable_id)->email }}</span>
                                    </div>
                                    <!--begin::User details-->
                                </td>
                                <!--end::Customer=-->
                                <td>
                                    <div class="badge badge-dark"> {{ getUserTypeModelName($value->userable_type) }}</div>

                                </td>

                                <!--begin::email=-->
                                <td>
                                    <div class="badge badge-light">{{ getUserModel($value->userable_type,$value->userable_id)->email }}</div>
                                </td>
                                <!--end::email=-->
                                <!--begin::phone=-->
                                <td>
                                    <div class="badge badge-light">{{ getUserModel($value->userable_type,$value->userable_id)->phone }}</div>
                                </td>
                                <!--end::phone=-->
                                <td>
                                    <div class="badge badge-success">   {{ $value->amount }}</div>

                                </td>
                                <!--begin::Date=-->
                                <td>{{ $value->created_at->format('Y-m-d g:i A') }}</td>
                                <!--end::Date=-->

                            </tr>
                        @endforeach

                        </tbody>
                        <!--end::Table body-->
                    </table>
                    {!! $data->render() !!}
                </div>
                <!--end::Card body-->
            @endif


        </div>
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
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
    <script>
        $( "body" ).on( "change", "select[name='time']", function() {
            var id = $(this).val();
            if(id == "exact_time"){
                $('#from-div').show();
                $('#to-div').show();
            }else{
                $('#from-div').hide();
                $('#to-div').hide();
            }
        });
        $( "body" ).on( "change", "select[name='user_type']", function() {
            var id = $(this).val();
            if(id ){
                $('#all-users').empty();
                $.ajax({
                    url: '/admin/get/all-users',
                    type: "GET",
                    data:{class_name:id},
                    dataType: "json",
                    success: function (data) {

                        if (data['users'].length > 0) {

                            $('#all-users').append('<label class="fs-6 form-label fw-bold text-dark">اختر المستخدم</label>' +
                                '  <select class="form-select form-select-solid" id="username" name="username" data-control="select2" data-placeholder="اختر المستخدم" data-hide-search="false"><option value="">اختر</option>');


                            $.each(data['users'], function (index, users) {


                                $('select[name="username"]').append('<option  value="' + users.id + '">' + users.name + '</option>');


                            });
                            $('#all-users').append(' </select>');
                            $("#username").select2();


                        }


                    }
                });

            }

            else{
                $('#all-users').empty();
            }


        });
    </script>

@endsection
