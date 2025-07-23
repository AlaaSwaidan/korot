@extends('admin.layouts.master')

@section('title')
   تحويلات {{ $name }}
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
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">تحويلات
                    {{  $admin->name  }}</h1>
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
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.transfers.index','type=admins') }}" class="text-muted text-hover-primary">تحويلات المدراء</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">تحويلات {{ $admin->name }}</li>
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

            <!--begin::Form-->
            <form action="{{ route('admin.transfers.search.admin',$admin->id) }}" >
                <!--begin::Card-->
                <div class="card mb-7">
                    <!--begin::Card body-->
                    <div class="card-body">
                        <!--begin::Compact form-->
                        <!--begin::Input group-->
                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-lg-6">
                                <label class="fs-6 form-label fw-bold text-dark">الفترة الزمنية</label>
                                <!--begin::Select-->
                                <select class="form-select form-select-solid" name="time" data-control="select2" data-placeholder="الفترة الزمنية" data-hide-search="true">
                                    <option value=""></option>
                                    <option value="today" {{ isset($time) && $time == "today" ? 'selected' : '' }}>اليوم</option>
                                    <option value="yesterday"  {{ isset($time) && $time == "yesterday" ? 'selected' : '' }}>أمس</option>
                                    <option value="current_week"  {{ isset($time) && $time == "current_week" ? 'selected' : '' }}>الأسبوع الحالي</option>
                                    <option value="current_month" {{ isset($time) && $time == "current_month" ? 'selected' : '' }} >الشهر الحالي</option>
                                    <option value="month_ago"  {{ isset($time) && $time == "month_ago" ? 'selected' : '' }}>الشهر السابق</option>
                                    <option value="exact_time" {{ isset($time) && $time == "exact_time" ? 'selected' : '' }}>فترة محددة</option>
                                </select>
                                <!--end::Select-->
                            </div>
                            <!--end::Col-->

                            <!--begin::Col-->
                            <div id="from-div" style="@if(isset($from_date)) display: block; @else display: none; @endif" class="col-lg-6">
                                <label class="fs-6 form-label fw-bold text-dark">من</label>
                                <input type="date" class="form-control form-control form-control-solid" name="from_date" value="{{ isset($from_date) ? $from_date : null }}" />
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div id="to-div" style="@if(isset($from_date)) display: block; @else display: none; @endif" class="col-lg-6">
                                <label class="fs-6 form-label fw-bold text-dark">الى</label>
                                <input type="date" class="form-control form-control form-control-solid" name="to_date" value="{{ isset($to_date) ? $to_date : null }}" />
                            </div>
                            <!--end::Col-->
                            <input type="hidden" name="type" value="{{ $type }}">

                            <!--begin::Col-->
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center" style="margin-top: 27px;">
                                    <button type="submit" class="btn btn-primary me-5">بحث</button>
                                </div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->

                        <!--end::Input group-->
                        <!--begin:Action-->

                        <!--end:Action-->

                        <!--end::Compact form-->

                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </form>
            <!--end::Form-->
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Group actions-->
                    <div class="d-flex justify-content-end align-items-center d-none" data-kt-subscription-table-toolbar="selected">
                        <div class="fw-bold me-5">
                            <span class="me-2" data-kt-subscription-table-select="selected_count"></span> المحدد </div>
                        <button type="button" class="btn btn-danger" data-kt-subscription-table-select="delete_selected">احذف المحدد</button>
                    </div>
                    <!--end::Group actions-->

                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_subscriptions_table">
                        <!--begin::Table head-->
                        <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                            <th >#</th>
                            <th >من طرف</th>
                            <th >الرصيد</th>
                            <th>نوع التحويل</th>
                            <th>وصل التحويل</th>
                            <th >التاريخ</th>

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
                                @if($value->fromAdmin->image)
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="{{ $value->fromAdmin->image_full_path }}">
                                        <div class="symbol-label">
                                            <img src="{{ $value->fromAdmin->image_full_path }}" alt="{{ $value->fromAdmin->name }}" class="w-100">
                                        </div>
                                    </a>
                                </div>
                                @endif
                                <!--end::Avatar-->
                                <!--begin::User details-->
                                <div class="d-flex flex-column">
                                    <a href="{{ route('admin.admins.show',$value->fromAdmin->id) }}" class="text-gray-800 text-hover-primary mb-1">{{ $value->fromAdmin->name }}</a>
                                    <span>{{ $value->fromAdmin->email }}</span>
                                </div>
                                <!--begin::User details-->
                            </td>
                            <!--end::Customer=-->
                            <td>
                                <div class="badge badge-light-info">  {{ $value->amount }}</div>
                            </td>
                            <td>
                                {{ $value->transfer_type == "fawry" ? "فوري" : "آجل" }}
                            </td>

                            <td>
                                <a href="{{ route('admin.transfers.balance-admin-pdf', $value->id) }}" target="_blank" class="text-gray-800 text-hover-primary mb-1">وصل التحويل</a>
                            </td>



                            <!--begin::Status=-->
                            <td>
                                <div class="badge badge-light-danger">{{ $value->created_at->format('Y-m-d g:i A')}}</div>
                            </td>
                            <!--end::Status=-->

                        </tr>
                        @endforeach

                        </tbody>
                        <!--end::Table body-->
                    </table>
                    {!! $data->render() !!}
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
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
    </script>
@endsection
