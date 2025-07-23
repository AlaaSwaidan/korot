@extends('admin.layouts.master')

@section('title')
    عرض تفاصيل المورد
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
                        <a href="{{ route('admin.suppliers.index') }}" class="text-muted text-hover-primary">التجار</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">عرض تفاصيل المورد</li>
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
            @include('purchases::suppliers._profile')

            <!--begin::details View-->
            <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_subscriptions_table">
                        <!--begin::Table head-->
                        <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                            <th >#</th>
                            <th >رقم الفاتورة</th>
                            <th >اسم المورد</th>
                            <th >الاجمالي قبل الضريبة</th>
                            <th >الاجمالي بعد الضريبة</th>
                            <th >تاريخ امر الشراء</th>
                            <th >الخيارات</th>
                        </tr>
                        <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="text-gray-600 fw-semibold">
                        <?php $i = 0; ?>
                        @foreach($invoices as $value )
                                <?php ++$i; ?>
                            <tr>

                                <td> {{ $i }} </td>

                                <!--begin::Customer=-->
                                <td class="d-flex align-items-center">
                                    {{ $value->invoice_id }}
                                </td>
                                <!--end::Customer=-->
                                <td>
                                    {{ $value->supplier->name }}
                                </td>
                                <!--begin::email=-->
                                <td>
                                    <div class="badge badge-light">{{ $value->total_before_tax }}</div>
                                </td>
                                <!--end::email=-->
                                <!--begin::phone=-->
                                <td>
                                    <div class="badge badge-light">{{ $value->total_after_tax }}</div>
                                </td>
                                <!--end::phone=-->
                                <!--begin::Date=-->
                                <td>{{ $value->purchase_order_date }}</td>
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

                                        @if($value->confirm == 0)

                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="{{ route('admin.purchase-orders.edit',$value->id) }}" class="menu-link px-3">تعديل</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="{{ route('admin.purchase-orders.confirm-page',$value->id) }}" class="menu-link px-3">تأكيد الفاتورة</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a  data="{{ $value->id }}" data_name="{{$value->name }}"   class="menu-link text-danger px-3 delete_row">حذف</a>
                                            </div>

                                            <!--end::Menu item-->
                                        @else
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="{{ route('admin.purchase-orders.show',$value->id) }}" class="menu-link px-3">عرض</a>
                                            </div>
                                            <!--end::Menu item-->
                                        @endif

                                    </div>
                                    <!--end::Menu-->
                                </td>
                                <!--end::Action=-->
                            </tr>
                        @endforeach

                        </tbody>
                        <!--end::Table body-->
                    </table>
                    {!! $invoices->render() !!}
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
