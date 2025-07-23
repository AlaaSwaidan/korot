@extends('admin.layouts.master')

@section('title')
   البطاقات التي تم رفعها
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
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">البطاقات التي تم رفعها</h1>
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
                    <li class="breadcrumb-item text-muted">البطاقات التي تم رفعها</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">{{ $package->name['ar'] }}</li>
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

        <div class="card mb-5 mb-xl-10">
            <div class="card-body pt-9 pb-0">
                <!--begin::Add subscription-->
                <a href="{{ route('admin.uploaded-card-index.store',$package->id) }}" class="btn btn-primary">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                    <span class="svg-icon svg-icon-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->تأكيد رفع البطاقات الصحيحة</a>
                <!--begin::Add subscription-->
                <a href="{{ route('admin.uploaded-card-index.cancel',$package->id) }}" class="btn btn-danger">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                    <i class="la la-times"></i>
                    <!--end::Svg Icon-->الغاء رفع البطاقات الغير صحيحة</a>
                <!--end::Add subscription-->
                <!--begin::Navs-->
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                    <!--begin::Nav item-->
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ Route::currentRouteName() == 'admin.uploaded-card-index.index' ? 'active' : '' }}" href="{{ route('admin.uploaded-card-index.index',$package->id) }}">البطاقات التي تم رفعها الصحيحة</a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ Route::currentRouteName() == 'admin.uploaded-card-index-errors.index' ? 'active' : '' }}" href="{{ route('admin.uploaded-card-index-errors.index',$package->id) }}">البطاقات التي تم رفعها الغير صحيحة</a>
                    </li>
                    <!--end::Nav item-->
                </ul>
                <!--begin::Navs-->
                <hr>
                <!--begin::Content container-->
                <div id="kt_app_content_container" class="app-container container-xxl">
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
                            <!--begin::Card title-->
                            {{--                    <div class="card-title">--}}
                            {{--                        <!--begin::Search-->--}}
                            {{--                        <div class="d-flex align-items-center position-relative my-1">--}}
                            {{--                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->--}}
                            {{--                            <span class="svg-icon svg-icon-1 position-absolute ms-6">--}}
                            {{--                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
                            {{--                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />--}}
                            {{--                                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />--}}
                            {{--                                </svg>--}}
                            {{--                            </span>--}}
                            {{--                            <!--end::Svg Icon-->--}}
                            {{--                            <input type="text" data-kt-subscription-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search Subscriptions" />--}}
                            {{--                        </div>--}}
                            {{--                        <!--end::Search-->--}}
                            {{--                    </div>--}}
                            <!--begin::Card title-->
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
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                            <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_subscriptions_table .form-check-input" value="0" />
                                        </div>
                                    </th>
                                    <th >#</th>
                                    <th >رقم البطاقة</th>
                                    <th >الرقم التسلسلي</th>
                                    <th >تاريخ الانتهاء</th>
                                    <th >التاريخ</th>
                                    @if(isset($error))
                                        <th >السبب</th>
                                    @endif

                                    <th >الخيارات</th>
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
                                                <input class="form-check-input" type="checkbox" value="{{ $value->id }}" />
                                            </div>
                                        </td>
                                        <!--end::Checkbox-->
                                        <td> {{ $i }} </td>

                                        <td class="editable" data-id="{{ $value->id }}" data-column="card_number">
                                            <div class="badge badge-light-info">  {{ $value->card_number  }}</div>
                                        </td>
                                        <td class="editable" data-id="{{ $value->id }}" data-column="serial_number">
                                            <div class="badge badge-light-info">  {{ $value->serial_number }}</div>
                                        </td>
                                        <td class="editable" data-id="{{ $value->id }}" data-column="end_date">
                                            <div class="badge badge-light-info">  {{ $value->end_date }}</div>
                                        </td>
                                        @if(isset($error))
                                            <td> {{ $value->reason }}</td>
                                        @endif
                                        <!--begin::Date=-->
                                        <td>{{ $value->created_at->format('Y-m-d g:i A') }}</td>
                                        <!--end::Date=-->
                                        <!--begin::Action=-->
                                        <td >
                                            <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">الخيارات
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                <span class="svg-icon svg-icon-5 m-0">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                                <!--end::Svg Icon--></a>
                                            <!--begin::Menu-->
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                {{--                                    <!--begin::Menu item-->--}}
                                                {{--                                    <div class="menu-item px-3">--}}
                                                {{--                                        <a href="{{ route('admin.cards.show',[$category->id,$value->id]) }}" class="menu-link px-3">عرض</a>--}}
                                                {{--                                    </div>--}}
                                                {{--                                    <!--end::Menu item-->--}}
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="{{ route('admin.uploaded-card-index.edit',$value->id) }}" class="menu-link px-3">تعديل</a>
                                                </div>
                                                <!--end::Menu item-->

                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a  data="{{ $value->id }}" data_name="{{$value->card_number }}"   class="menu-link text-danger px-3 delete_row">حذف</a>
                                                </div>

                                                <!--end::Menu item-->
                                            </div>
                                            <!--end::Menu-->
                                        </td>
                                        <!--end::Action=-->
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
        </div>

    </div>
    <!--end::Content-->
      @include('company::cards._models')

@endsection
@section('scripts')
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="{{ URL::asset('admin/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

    <!--end::Javascript-->
    <script>
        $(document).ready(function() {
            // Make table cells editable
            $('.editable').on('click', function() {
                var cell = $(this);
                var value = cell.text();
                cell.html('<input type="text" value="">');
                cell.find('input').focus();
            });
            var CSRF_TOKEN = $('meta[name="X-CSRF-TOKEN"]').attr('content');
            // Update data on input blur
            $('.editable').on('blur', 'input', function() {
                var cell = $(this).parent();
                var value = $(this).val();
                var remove = $(this).closest('tr');
                var id = cell.data('id');
                var column = cell.data('column');

                $.ajax({
                    url: '/admin/update-uploaded-cards',
                    type: 'POST',
                    data: {
                        id: id,
                        column: column,
                        serial_number: (column === "serial_number" ? value : null),
                        end_date: (column === "end_date" ? value : null),
                        card_number: (column === "card_number" ? value : null),
                        _token: CSRF_TOKEN,
                        value: value
                    },
                    success: function(response) {
                        if(response.success === false){
                            toastr.error(response.message);
                        }else{
                            cell.text(value);
                            if(response.check === true){
                                remove.remove();
                            }
                            toastr.success("تم التعديل بنجاح");
                        }

                    }
                });
            });
        });
    </script>

    <script>

        var page_name = 'البطاقات التي تم رفعها';
        var selected_url_delete = "{{ url('/') }}" + "/admin/uploaded-card-index/selected/destroy" ;
        var CSRF_TOKEN = $('meta[name="X-CSRF-TOKEN"]').attr('content');
        $(document).ready(function() {

            var CSRF_TOKEN = $('meta[name="X-CSRF-TOKEN"]').attr('content');

            $('body').on('click', '.delete_row', function() {

                var id = $(this).attr('data');
                var name = $(this).attr('data_name');

                // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                Swal.fire({
                    text: "هل أنت متأكد من حذف  " + name + " ؟ ",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "تأكيد",
                    cancelButtonText: "إلغاء",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    }
                }).then(function (result) {
                    if (result.value) {

                        $.ajax({
                            url: "{{ url('/') }}" + "/admin/uploaded-card-index/destroy" ,
                            type: "POST",
                            data: {_token: CSRF_TOKEN, 'id': id},
                        })
                            .done(function(reseived_data) {
                                var parsed_data = $.parseJSON(reseived_data);

                                if(parsed_data.code === '1'){
                                    Swal.fire({
                                        text: "تم حذف البطاقة " + name + "!.",
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "تأكيد",
                                        customClass: {
                                            confirmButton: "btn fw-bold btn-primary",
                                        }
                                    }).then(function () {
                                        // Remove current row
                                        window.location.href = parsed_data.url;
                                    });

                                }
                                else{
                                    Swal.fire({
                                        text:    parsed_data.message ,
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn fw-bold btn-primary",
                                        }
                                    });
                                }
                            });

                    } else if (result.dismiss === 'cancel') {
                        Swal.fire({
                            text: name + " لم يتم حذفه. ",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "تأكيد",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            }
                        });
                    }
                });

            });

        });

    </script>
@endsection
