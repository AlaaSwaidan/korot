@extends('admin.layouts.master')

@section('title')
    التجار
@endsection

@section('page_header')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">التجار</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('admin.distributors.index') }}" class="text-muted text-hover-primary">التجار</a>
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
            @include('distributor::distributors._profile')
            <!--begin::details View-->
            <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">

                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <form style="margin-top: 10px; float: left" action="{{route('admin.distributors.distributors-merchants-excel')}}" method="post" >
                        @csrf

                        <button type="submit"  class="btn btn-success disabledbutton">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                            <i class="fas fa-file-excel"></i>
                            <!--end::Svg Icon-->
                        </button>
                        <input type="hidden" name="type" value="distributors">
                        <input type="hidden" name="user_id" value="{{ $distributor->id }}">

                    </form>
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_subscriptions_table">
                        <!--begin::Table head-->
                        <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                            <th >#</th>
                            <th >رقم التاجر</th>
                            <th >الاسم</th>
                            <th >رقم الماكينة</th>
                            <th >تمت الاضافة</th>
                            <th >حالة العضوية</th>
                            <th >البريد الالكتروني</th>
                            <th >رقم الجوال</th>
                            <th >التاريخ</th>
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
                                <td>{{ $value->machine_number }}</td>
                                <td>
                                    <div class="badge badge-light-info">  {{ $value->distributor_id ? $value->distributor->name :  added_by_type($value->added_by_type,$value) }}</div>
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
            <!--end::details View-->

        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
@endsection
@section('scripts')
    <script>
        $( "body" ).on( "change", "select[name='time']", function() {
            var id = $(this).val();
            if(id === "exact_time"){
                $('#from-div').show();
                $('#to-div').show();
            }else{
                $('#from-div').hide();
                $('#to-div').hide();
            }
        });


    </script>
@endsection
