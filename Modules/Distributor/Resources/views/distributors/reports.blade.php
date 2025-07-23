@extends('admin.layouts.master')

@section('title')
    الموزعين
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
            <div class="card">
                <h4>بحث لمبيعات  الموزعين</h4>
                <form action="{{ route('admin.distributors.print-reports') }}" method="post">
                    @csrf
                    <!--begin::Card-->
                    <div class="card mb-7">
                        <!--begin::Card body-->
                        <div class="card-body">
                            <!--begin::Compact form-->
                            <div class="d-flex align-items-center">
                                <!--begin::Input group-->
                                <div class="position-relative w-md-400px me-md-2" style="margin-bottom: 25px;">
                                    <!--begin::Col-->
                                    <!--end::Col-->
                                    <input type="hidden" name="type" value="distributors">
                                    <!--end::Col-->

                                    <!--begin::Row-->
                                    <div class="row g-8">
                                        <!--begin::Col-->
                                        <div  class="col-lg-6">
                                            <label class="fs-6 form-label fw-bold text-dark">من</label>
                                            <input type="date" class="form-control form-control form-control-solid" name="from_date" value="{{ isset($startDate) ? $startDate->format('Y-m-d') : null }}" />
                                        </div>
                                        <!--end::Col-->

                                        <!--begin::Col-->
                                        <div   class="col-lg-6">
                                            <label class="fs-6 form-label fw-bold text-dark">الى</label>
                                            <input type="date" class="form-control form-control form-control-solid" name="to_date" value="{{ isset($endDate) ? $endDate->format('Y-m-d') : null }}" />

                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        {{--                                <div class="col-lg-6">--}}
                                        {{--                                    <label class="fs-6 form-label fw-bold text-dark">النوع</label>--}}
                                        {{--                                    <!--begin::Select-->--}}
                                        {{--                                    <select class="form-select form-select-solid" name="payment" data-control="select2" data-placeholder="النوع" data-hide-search="true">--}}
                                        {{--                                        <option value="all">الكل</option>--}}
                                        {{--                                        <option value="wallet" {{ isset($payment) && $payment == "wallet" ? 'selected' : '' }}>المحفظة</option>--}}
                                        {{--                                        <option value="online" {{ isset($payment) && $payment == "online" ? 'selected' : '' }}>جيديا (شبكة)</option>--}}
                                        {{--                                    </select>--}}
                                        {{--                                    <!--end::Select-->--}}
                                        {{--                                </div>--}}
                                        <!--end::Col-->

                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Input group-->


                                <!--begin:Action-->
                                <div class="d-flex align-items-center">
                                    <button type="submit" class="btn btn-primary me-5 ">طباعة</button>
                                </div>
                                <!--begin:Action-->
                                <!--end:Action-->
                            </div>
                            <!--end::Compact form-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </form>
                <!--end::Form-->

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

@endsection
