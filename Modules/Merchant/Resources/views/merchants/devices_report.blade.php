@extends('admin.layouts.master')

@section('title')
    تقرير الاجهزة
@endsection
@section('styles')

    <style>

        #search-input-field{
            padding: 10px 51px;
            background-color: #F1F5F7;
            border-radius: 25px;
            height: 45px;
            border: none;
        }
        #search-input-field::placeholder{
            font-size: 16px;
        }
        .search-btn{
            background-color: transparent;
            border: none;
            position: absolute;
            left: 15px;
            top: 12px;
        }
        .search-btn i{
            color: #717A82;
            font-size: 14px;
        }

        @media(max-width: 767px){
            .form-group h4{
                text-align: center;
                margin-bottom: 25px;
            }
            #search-input-field{
                margin-bottom: 20px;
            }
        }
    </style>

@endsection
@section('page_header')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0"> تقرير الاجهزة</h1>
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
                    <li class="breadcrumb-item text-muted">التجار</li>
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
                    <form action="{{ route('admin.devices-report.index') }}" method="get">
                        <div class="d-flex align-items-center gap-3">

                            <!-- Search Input -->
                            <!--begin::Input group-->

                                <lable>من</lable>
                                <!--begin::Col-->
                                <input type="date" class="form-control form-control form-control-solid" name="from_date" value="{{ request()->from_date }}" />

                                <!--end::Col-->

                            <!--end::Input group-->
                            <!--begin::Input group-->

                                <label>الى</label>
                                <!--begin::Col-->
                                <input type="date" class="form-control form-control form-control-solid" name="to_date" value="{{ request()->to_date  }}" />

                                <!--end::Col-->

                            <!--end::Input group-->

                            <lable>حالة الاجهزة</lable>
                            <!-- Time Select -->
                            <select class="form-select form-select-solid"
                                    name="mada_inactive"
                                    data-control="select2"
                                    data-placeholder="حالة الاجهزة"
                                    data-hide-search="true"
                                    style="min-width:150px;">
                                <option value=""></option>
                                <option value="0" {{ (request()->mada_inactive != null && request()->mada_inactive == 0) ? 'selected' : '' }}>خاملة مدى</option>
                                <option value="1" {{ (request()->mada_inactive != null && request()->mada_inactive == 1) ? 'selected' : '' }}>نشطة مدى</option>
                            </select>
                            <!-- Search Button -->
                            <button type="submit" class="btn btn-primary">
                                بحث
                            </button>
                        </div>
                    </form>

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
                            <th >رقم التاجر</th>
                            <th >الاسم</th>
                            <th >رقم الماكينة</th>
                            <th >البريد الالكتروني</th>
                            <th >رقم الجوال</th>
                            <th >اجمالي المبيعات مدى</th>
                            <th >اجمالي المبيعات محفظة</th>
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

                                <td>{{ $value->id }}</td>
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


                                <!--begin::email=-->
                                <td>
                                    <div class="badge badge-light">{{ $value->machine_number }}</div>
                                </td>
                                <!--end::email=-->
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
                                <!--begin::phone=-->
                                <td>
                                    <div class="badge badge-light">{{ $value->online_total ?? 0 }}</div>
                                </td>
                                <!--end::phone=-->
                                <!--begin::phone=-->
                                <td>
                                    <div class="badge badge-light">{{ $value->wallet_total ?? 0 }}</div>
                                </td>
                                <!--end::phone=-->
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
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="{{ route('admin.merchants.show',$value->id) }}" class="menu-link px-3">عرض</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="{{ route('admin.merchants.edit',$value->id) }}" class="menu-link px-3">تعديل</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="{{ route('admin.merchants.prices',$value->id) }}" class="menu-link px-3">تعديل الأسعار</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="{{ route('admin.merchants.change-password',$value->id) }}" class="menu-link px-3">تغيير كلمة المرور</a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a  data="{{ $value->id }}" data_name="{{$value->name }}"   class="menu-link text-danger px-3 delete_row">حذف</a>
                                        </div>
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a  data="{{ $value->id }}" data_name="{{$value->name }}"   class="menu-link text-danger px-3 delete_token">حذف التوكن</a>
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
        var page_name = 'التجار';
        var selected_url_delete = "{{ url('/') }}" + "/admin/merchants/selected/destroy" ;
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
                            url: "{{ url('/') }}" + "/admin/merchants/destroy" ,
                            type: "POST",
                            data: {_token: CSRF_TOKEN, 'id': id},
                        })
                            .done(function(reseived_data) {
                                var parsed_data = $.parseJSON(reseived_data);

                                if(parsed_data.code === '1'){
                                    Swal.fire({
                                        text: "تم حذف التاجر " + name + "!.",
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
            $('body').on('click', '.delete_token', function() {

                var id = $(this).attr('data');
                var name = $(this).attr('data_name');

                // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                Swal.fire({
                    text: "هل أنت متأكد من حذف سيشن  " + name + " ؟ ",
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
                            url: "{{ url('/') }}" + "/admin/merchants/destroy-token" ,
                            type: "POST",
                            data: {_token: CSRF_TOKEN, 'id': id},
                        })
                            .done(function(reseived_data) {
                                var parsed_data = $.parseJSON(reseived_data);

                                if(parsed_data.code === '1'){
                                    Swal.fire({
                                        text: "تم حذف سيشن التاجر " + name + "!.",
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
