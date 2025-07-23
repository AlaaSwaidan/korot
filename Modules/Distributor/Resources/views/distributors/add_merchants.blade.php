@extends('admin.layouts.master')

@section('title')
    الموزعين
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
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">الموزعين</h1>
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
                    <li class="breadcrumb-item text-muted">الموزعين</li>
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
            <form action="{{ route('admin.distributors.store-merchants',$distributor->id) }}" method="post">
                @csrf
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">

                    <!--begin::Card toolbar-->
{{--                    <div class="card-toolbar">--}}
{{--                        <!--begin::Toolbar-->--}}
{{--                        <div class="d-flex justify-content-end" data-kt-subscription-table-toolbar="base">--}}

{{--                            <!--begin::Add subscription-->--}}
{{--                            <button type="submit" class="btn btn-primary">--}}
{{--                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->--}}
{{--                                <span class="svg-icon svg-icon-2">--}}
{{--                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />--}}
{{--                                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />--}}
{{--                                    </svg>--}}
{{--                                </span>--}}
{{--                                <!--end::Svg Icon-->إضافة التجار</button>--}}
{{--                            <!--end::Add subscription-->--}}
{{--                        </div>--}}
{{--                        <!--end::Toolbar-->--}}
{{--                    </div>--}}
                    <!--end::Card toolbar-->
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
                            <th class="w-10px pe-2">
{{--                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">--}}
{{--                                    <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_subscriptions_table .form-check-input" value="0" />--}}
{{--                                </div>--}}
                            </th>
                            <th >#</th>
                            <th >الاسم</th>
                            <th >رقم الماكينة</th>
                            <th >حالة العضوية</th>
                            <th >البريد الالكتروني</th>
                            <th >رقم الجوال</th>
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
                                <!--begin::Checkbox-->
                                <td>
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" name="merchants[]" {{ $value->distributor_id == $distributor->id ? 'checked' : '' }} value="{{ $value->id }}" />
                                    </div>
                                </td>
                                <!--end::Checkbox-->
                                <td> {{ $i }} </td>

                                <!--begin::Customer=-->
                                <td class="d-flex align-items-center">
                                    <!--begin:: Avatar -->
                                    @if($value->image)
                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                            <a href="{{ $value->image_full_path }}">
                                                <div class="symbol-label">
                                                    <img src="{{ $value->image_full_path }}" alt="{{ $value->name }}" class="w-100">
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                    <!--end::Avatar-->
                                    <!--begin::User details-->
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('admin.merchants.show',$value->id) }}" class="text-gray-800 text-hover-primary mb-1">{{ $value->name }}</a>
                                        <span>{{ $value->email }}</span>
                                    </div>
                                    <!--begin::User details-->
                                </td>
                                <!--end::Customer=-->
                                <td>
                                    {{ $value->machine_number ?? '--' }}
                                </td>

                                <!--begin::Status=-->
                                <td>
                                    <div class="badge badge-light-{{ $value->active == 1 ?  'success' : "danger"}}">{{ $value->active == 1 ? "مفعل " : "غير مفعل"}}</div>
                                </td>
                                <!--end::Status=-->
                                <!--begin::email=-->
                                <td>
                                    <div class="badge badge-light">{{ $value->email }}</div>
                                </td>
                                <!--end::email=-->
                                <!--begin::phone=-->
                                <td>
                                    <div class="badge badge-light">{{ $value->phone }}</div>
                                </td>
                                <!--end::phone=-->
                                <!--begin::Date=-->
                                <td>{{ $value->created_at->format('Y-m-d g:i A') }}</td>
                                <!--end::Date=-->

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
            </form>
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
        var page_name = 'الموزعين';
        var selected_url_delete = "{{ url('/') }}" + "/admin/distributors/selected/merchants" ;
        var CSRF_TOKEN = $('meta[name="X-CSRF-TOKEN"]').attr('content');


    </script>

    <script>
        $(document).ready(function () {
            $('input[type="checkbox"]').on('change', function () {
                // Get the checkbox value
                var checkboxstatus = $(this).is(':checked');
                var value = $(this).val();

                // Send AJAX request to the Laravel backend
                $.ajax({
                    url: "{{ route('admin.distributors.store-merchants',$distributor->id) }}" ,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        checkboxstatus: checkboxstatus ,
                        merchants:value
                    },
                    success: function (response) {
                        // Handle the response if needed
                        if(response['success'] === 1){
                            toastr.success(response['message']);
                        }else{
                            toastr.error(response['message']);
                        }

                    },
                    error: function (xhr) {
                        // Handle errors if needed
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
