@extends('admin.layouts.master')

@section('title')
    @lang('messages.Dashboards')
@endsection

@section('content')
    <!--begin::Main-->
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Toolbar-->
            <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                <!--begin::Toolbar container-->
                <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                    <!--begin::Page title-->
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <!--begin::Title-->
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">لوحة التحكم</h1>
                        <!--end::Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.home') }}" class="text-muted text-hover-primary">لوحة التحكم</a>
                            </li>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <li class="breadcrumb-item text-muted">الرئيسية</li>
                            <!--end::Item-->
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page title-->

                </div>
                <!--end::Toolbar container-->
            </div>
            <!--end::Toolbar-->
            <!--begin::Content-->
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Form-->
                <form action="{{ route('admin.home.search') }}">
                    <!--begin::Card-->
                    <div class="card mb-7">
                        <!--begin::Card body-->
                        <div class="card-body">
                            <!--begin::Compact form-->
                            <div class="d-flex align-items-center">
                                <!--begin::Input group-->
                                <div class="position-relative w-md-400px me-md-2">
                                    <div class="d-flex align-items-center">
                                        <!--begin::Col-->
                                        <!--begin::Select-->
                                        <select class="form-select form-select-solid" name="time" data-control="select2" data-placeholder="الفترة الزمنية" data-hide-search="true">
                                            <option value=""></option>
                                            <option value="today" {{ isset($time) && $time == "today" ? 'selected' : '' }}>اليوم</option>
                                            <option value="current_month" {{ isset($time) && $time == "current_month" ? 'selected' : '' }} >الشهر الحالي</option>
                                            <option value="month_ago"  {{ isset($time) && $time == "month_ago" ? 'selected' : '' }}>الشهر السابق</option>
                                            <option value="exact_time" {{ isset($time) && $time == "exact_time" ? 'selected' : '' }}>فترة محددة</option>
                                        </select>
                                        <!--end::Select-->
                                        <!--end::Col-->
                                    </div>
                                    <!--begin::Row-->
                                    <div class="row g-8 mb-8">
                                        <!--begin::Col-->
                                        <!--begin::Row-->
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

                                        <!--end::Row-->
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->

                                </div>
                                <!--end::Input group-->

                                <!--begin:Action-->
                                <div class="d-flex align-items-center">
                                    <button type="submit" class="btn btn-primary me-5 disabledbutton">بحث</button>
                                </div>
                                <!--end:Action-->
                            </div>
                            <!--end::Compact form-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </form>
                <!--end::Form-->


                <!--begin::Content container-->
                <div id="kt_app_content_container" class="app-container container-fluid">
                    <!--begin::Row-->
                    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                        <!--begin::Col-->
                        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                            <!--begin::Card widget 20-->
                            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10" style="background-color: #F1416C;background-image:url('assets/media/patterns/vector-1.png');height:90% !important;">
                                <!--begin::Header-->
                                <div class="card-header pt-5">
                                    <!--begin::Title-->
                                    <div class="card-title d-flex flex-column">
                                        <!--begin::Amount-->
                                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $active_sellers }}</span>
                                        <!--end::Amount-->
                                        <!--begin::Subtitle-->
                                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">التجار النشطين</span>
                                        <!--end::Subtitle-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Header-->
                                <div class="card-header pt-5">
                                    <!--begin::Title-->
                                    <div class="card-title d-flex flex-column">
                                        <!--begin::Amount-->
                                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $inactive_sellers }}</span>
                                        <!--end::Amount-->
                                        <!--begin::Subtitle-->
                                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">التجار الخاملين</span>
                                        <!--end::Subtitle-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Card body-->
                                <div class="card-body d-flex align-items-end pt-0">
                                    <!--begin::Progress-->
                                    <div class="d-flex align-items-center flex-column mt-3 w-100">
                                        <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                                            <span>{{ $Not_active_merchants }} التجار المعلقين</span>
                                            <span>{{ $percent }}%</span>
                                        </div>
                                        <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                                            <div class="bg-white rounded h-8px" role="progressbar" style="width: 72%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <!--end::Progress-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card widget 20-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10" >
                            <!--begin::Card widget 17-->
                            <div class="card card-flush h-md-50 mb-5 mb-xl-10" style="height:90% !important;">
                                <!--begin::Header-->
                                <div class="card-header pt-5">
                                    <!--begin::Title-->
                                    <div class="card-title d-flex flex-column">
                                        <!--begin::Info-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Currency-->
                                            <span class="fs-4 fw-semibold text-gray-400 me-1 align-self-start">SR</span>
                                            <!--end::Currency-->
                                            <!--begin::Amount-->
                                            <?php
                                            if (isset($transfers)){
                                                $total1 =$transfers->where('userable_type','App\Models\Merchant')->first() ? $transfers->where('userable_type','App\Models\Merchant')->first()->balance_total : 0;
                                                $total2 =$transfers->where('userable_type','App\Models\Distributor')->first() ? $transfers->where('userable_type','App\Models\Distributor')->first()->balance_total : 0;
                                                $total3 =$transfers->where('userable_type','App\Models\Admin')->first() ? $transfers->where('userable_type','App\Models\Admin')->first()->balance_total : 0;

                                            }
                                            ?>
                                            <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{  number_format(isset($transfers)  ? $total1+$total2+$total3 : $statistics->merchants_balance + $statistics->admins_balance + $statistics->distributors_balance,2) }}</span>
                                            <!--end::Amount-->

                                        </div>
                                        <!--end::Info-->
                                        <!--begin::Subtitle-->
                                        <span class="text-gray-400 pt-1 fw-semibold fs-6">ارصدة السوق</span>
                                        <!--end::Subtitle-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-2 pb-4 d-flex flex-wrap align-items-center">

                                    <!--begin::Labels-->
                                    <div class="d-flex flex-column content-justify-center flex-row-fluid">
                                        <!--begin::Label-->
                                        <div class="d-flex fw-semibold align-items-center">
                                            <!--begin::Bullet-->
                                            <div class="bullet w-8px h-3px rounded-2 bg-success me-3"></div>
                                            <!--end::Bullet-->
                                            <!--begin::Label-->
                                            <div class="text-gray-500 flex-grow-1 me-4">رصيد التجار</div>
                                            <!--end::Label-->
                                            <!--begin::Stats-->
                                            <div class="fw-bolder text-gray-700 text-xxl-end">SR {{ number_format(isset($transfers)  && $transfers->where('userable_type','App\Models\Merchant')->first() ? $transfers->where('userable_type','App\Models\Merchant')->first()->balance_total : $statistics->merchants_balance,2) }}</div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Label-->
                                        <div class="d-flex fw-semibold align-items-center my-3">
                                            <!--begin::Bullet-->
                                            <div class="bullet w-8px h-3px rounded-2 bg-primary me-3"></div>
                                            <!--end::Bullet-->
                                            <!--begin::Label-->
                                            <div class="text-gray-500 flex-grow-1 me-4">رصيد الموزعين</div>
                                            <!--end::Label-->
                                            <!--begin::Stats-->
                                            <div class="fw-bolder text-gray-700 text-xxl-end">SR {{ number_format(isset($transfers)  && $transfers->where('userable_type','App\Models\Distributor')->first() ? $transfers->where('userable_type','App\Models\Distributor')->first()->balance_total : $statistics->distributors_balance,2) }}</div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Label-->
                                        <div class="d-flex fw-semibold align-items-center my-3">
                                            <!--begin::Bullet-->
                                            <div class="bullet w-8px h-3px rounded-2 bg-primary me-3"></div>
                                            <!--end::Bullet-->
                                            <!--begin::Label-->
                                            <div class="text-gray-500 flex-grow-1 me-4">رصيد المدراء</div>
                                            <!--end::Label-->
                                            <!--begin::Stats-->
                                            <div class="fw-bolder text-gray-700 text-xxl-end">SR {{ number_format(isset($transfers)  && $transfers->where('userable_type','App\Models\Admin')->first() ? $transfers->where('userable_type','App\Models\Admin')->first()->balance_total : $statistics->admins_balance ,2)}}</div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Labels-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card widget 17-->

                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10" >
                            <!--begin::Card widget 17-->
                            <div class="card card-flush h-md-50 mb-5 mb-xl-10" style="height:90% !important;">
                                <!--begin::Header-->
                                <div class="card-header pt-5">
                                    <!--begin::Title-->
                                    <div class="card-title d-flex flex-column">
                                        <!--begin::Info-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Currency-->
                                            <span class="fs-4 fw-semibold text-gray-400 me-1 align-self-start">SR</span>
                                            <!--end::Currency-->
                                            <!--begin::Amount-->
                                            <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ number_format(isset($transfers) ? $transfers->where('type','sales')->sum('amount') : $statistics->total_sales,2) }}</span>
                                            <!--end::Amount-->

                                        </div>
                                        <!--end::Info-->
                                        <!--begin::Subtitle-->
                                        <span class="text-gray-400 pt-1 fw-semibold fs-6">اجمالي المبيعات</span>
                                        <!--end::Subtitle-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-2 pb-4 d-flex flex-wrap align-items-center">

                                    <!--begin::Labels-->
                                    <div class="d-flex flex-column content-justify-center flex-row-fluid">
                                        <!--begin::Label-->
                                        <div class="d-flex fw-semibold align-items-center">
                                            <!--begin::Bullet-->
                                            <div class="bullet w-8px h-3px rounded-2 bg-success me-3"></div>
                                            <!--end::Bullet-->
                                            <!--begin::Label-->
                                            <div class="text-gray-500 flex-grow-1 me-4">مبيعات البطاقات المربوطة</div>
                                            <!--end::Label-->
                                            <!--begin::Stats-->
                                            <div class="fw-bolder text-gray-700 text-xxl-end">SR {{ number_format(isset($transfers) ? $transfers->where('type','sales')->where('api_linked',1)->sum('amount')  :$statistics->api_sales,2) }}</div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Label-->
                                        <div class="d-flex fw-semibold align-items-center my-3">
                                            <!--begin::Bullet-->
                                            <div class="bullet w-8px h-3px rounded-2 bg-primary me-3"></div>
                                            <!--end::Bullet-->
                                            <!--begin::Label-->
                                            <div class="text-gray-500 flex-grow-1 me-4">مبيعات البطاقات الغير مربوطة</div>
                                            <!--end::Label-->
                                            <!--begin::Stats-->
                                            <div class="fw-bolder text-gray-700 text-xxl-end">SR {{ number_format(isset($transfers) ? $transfers->where('type','sales')->where('api_linked',0)->sum('amount')  : $statistics->not_api_sales ,2)}}</div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Labels-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card widget 17-->

                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10" >
                            <!--begin::Card widget 17-->
                            <div class="card card-flush h-md-50 mb-5 mb-xl-10" style="height:90% !important;">
                                <!--begin::Header-->
                                <div class="card-header pt-5">
                                    <!--begin::Title-->
                                    <div class="card-title d-flex flex-column">
                                        <!--begin::Info-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Amount-->
                                            <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ isset($transfers) ? $transfers->where('type','sales')->count()  : $statistics->total_card_sold }}</span>
                                            <!--end::Amount-->

                                        </div>
                                        <!--end::Info-->
                                        <!--begin::Subtitle-->
                                        <span class="text-gray-400 pt-1 fw-semibold fs-6">عدد البطاقات المباعة</span>
                                        <!--end::Subtitle-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-2 pb-4 d-flex flex-wrap align-items-center">

                                    <!--begin::Labels-->
                                    <div class="d-flex flex-column content-justify-center flex-row-fluid">
                                        <!--begin::Label-->
                                        <div class="d-flex fw-semibold align-items-center">
                                            <!--begin::Bullet-->
                                            <div class="bullet w-8px h-3px rounded-2 bg-success me-3"></div>
                                            <!--end::Bullet-->
                                            <!--begin::Label-->
                                            <div class="text-gray-500 flex-grow-1 me-4">عدد البطاقات المباعة المربوطة</div>
                                            <!--end::Label-->
                                            <!--begin::Stats-->
                                            <div class="fw-bolder text-gray-700 text-xxl-end">{{ isset($transfers) ? $transfers->where('type','sales')->where('api_linked',1)->count() :  $statistics->api_card_sold }}</div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Label-->
                                        <div class="d-flex fw-semibold align-items-center my-3">
                                            <!--begin::Bullet-->
                                            <div class="bullet w-8px h-3px rounded-2 bg-primary me-3"></div>
                                            <!--end::Bullet-->
                                            <!--begin::Label-->
                                            <div class="text-gray-500 flex-grow-1 me-4">عدد البطاقات المباعة غير المربوطة</div>
                                            <!--end::Label-->
                                            <!--begin::Stats-->
                                            <div class="fw-bolder text-gray-700 text-xxl-end">{{ isset($transfers) ? $transfers->where('type','sales')->where('api_linked',0)->count()  : $statistics->not_api_card_sold }}</div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Labels-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card widget 17-->

                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10" >
                            <!--begin::Card widget 17-->
                            <div class="card card-flush h-md-50 mb-5 mb-xl-10" style="height:90% !important;">
                                <!--begin::Header-->
                                <div class="card-header pt-5">
                                    <!--begin::Title-->
                                    <div class="card-title d-flex flex-column">
                                        <!--begin::Info-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Currency-->
                                            <span class="fs-4 fw-semibold text-gray-400 me-1 align-self-start">SR</span>
                                            <!--end::Currency-->
                                            <!--begin::Amount-->
                                            <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ number_format(isset($orders) ? $orders->sum('cost') : $statistics->total_cost,2) }}</span>
                                            <!--end::Amount-->

                                        </div>
                                        <!--end::Info-->
                                        <!--begin::Subtitle-->
                                        <span class="text-gray-400 pt-1 fw-semibold fs-6">اجمالي التكاليف</span>
                                        <!--end::Subtitle-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-2 pb-4 d-flex flex-wrap align-items-center">

                                    <!--begin::Labels-->
                                    <div class="d-flex flex-column content-justify-center flex-row-fluid">
                                        <!--begin::Label-->
                                        <div class="d-flex fw-semibold align-items-center">
                                            <!--begin::Bullet-->
                                            <div class="bullet w-8px h-3px rounded-2 bg-success me-3"></div>
                                            <!--end::Bullet-->
                                            <!--begin::Label-->
                                            <div class="text-gray-500 flex-grow-1 me-4">تكاليف البطاقات المربوطة</div>
                                            <!--end::Label-->
                                            <!--begin::Stats-->
                                            <div class="fw-bolder text-gray-700 text-xxl-end">SR {{ number_format(isset($orders) ? $orders->where('api_linked',1)->sum('cost')  : $statistics->api_card_cost,2) }}</div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Label-->
                                        <div class="d-flex fw-semibold align-items-center my-3">
                                            <!--begin::Bullet-->
                                            <div class="bullet w-8px h-3px rounded-2 bg-primary me-3"></div>
                                            <!--end::Bullet-->
                                            <!--begin::Label-->
                                            <div class="text-gray-500 flex-grow-1 me-4">تكلفة البطاقات الغير مربوطة</div>
                                            <!--end::Label-->
                                            <!--begin::Stats-->
                                            <div class="fw-bolder text-gray-700 text-xxl-end">SR {{ number_format(isset($orders) ?  $orders->where('api_linked',1)->sum('cost')  : $statistics->not_api_card_cost,2) }}</div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Labels-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card widget 17-->

                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10" >
                            <!--begin::Card widget 17-->
                            <div class="card card-flush h-md-50 mb-5 mb-xl-10" style="height:90% !important;">
                                <!--begin::Header-->
                                <div class="card-header pt-5">
                                    <!--begin::Title-->
                                    <div class="card-title d-flex flex-column">
                                        <!--begin::Info-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Currency-->
                                            <span class="fs-4 fw-semibold text-gray-400 me-1 align-self-start">SR</span>
                                            <!--end::Currency-->
                                            <!--begin::Amount-->
                                            <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ number_format(isset($orders) ?$orders->sum('card_price') -  $orders->sum('merchant_price')   : $statistics->total_profits,2) }}</span>
                                            <!--end::Amount-->

                                        </div>
                                        <!--end::Info-->
                                        <!--begin::Subtitle-->
                                        <span class="text-gray-400 pt-1 fw-semibold fs-6">ارباح التجار</span>
                                        <!--end::Subtitle-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-2 pb-4 d-flex flex-wrap align-items-center">
                                    <!--begin::Labels-->
                                    <div class="d-flex flex-column content-justify-center flex-row-fluid">
                                        <!--begin::Label-->
                                        <div class="d-flex fw-semibold align-items-center">
                                            <!--begin::Bullet-->
                                            <div class="bullet w-8px h-3px rounded-2 bg-success me-3"></div>
                                            <!--end::Bullet-->
                                            <!--begin::Label-->
                                            <div class="text-gray-500 flex-grow-1 me-4">ارباح البطاقات EVD</div>
                                            <!--end::Label-->
                                            <!--begin::Stats-->
                                            <div class="fw-bolder text-gray-700 text-xxl-end">SR {{ number_format(isset($orders) ? $orders->where('api_linked',1)->sum('card_price') -  $orders->where('api_linked',1)->sum('merchant_price')  :  $statistics->api_card_profits ,2)}}</div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Label-->
                                        <div class="d-flex fw-semibold align-items-center my-3">
                                            <!--begin::Bullet-->
                                            <div class="bullet w-8px h-3px rounded-2 bg-primary me-3"></div>
                                            <!--end::Bullet-->
                                            <!--begin::Label-->
                                            <div class="text-gray-500 flex-grow-1 me-4">ارباح البطاقات الغير مربوطة</div>
                                            <!--end::Label-->
                                            <!--begin::Stats-->
                                            <div class="fw-bolder text-gray-700 text-xxl-end">SR {{ number_format(isset($orders) ? $orders->where('api_linked',0)->sum('card_price') -  $orders->where('api_linked',0)->sum('merchant_price')  :  $statistics->not_api_card_profits,2) }}</div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Labels-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card widget 17-->

                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10" >
                            <!--begin::Card widget 17-->
                            <div class="card card-flush h-md-50 mb-5 mb-xl-10" style="height:90% !important;">
                                <!--begin::Header-->
                                <div class="card-header pt-5">
                                    <!--begin::Title-->
                                    <div class="card-title d-flex flex-column">
                                        <!--begin::Info-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Currency-->
                                            <span class="fs-4 fw-semibold text-gray-400 me-1 align-self-start">SR</span>
                                            <!--end::Currency-->
                                            <!--begin::Amount-->
                                            <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{number_format(  isset($orders) ? $orders->sum('merchant_price') -  $orders->sum('cost')  :  $statistics->total_mine_profits,2) }}</span>
                                            <!--end::Amount-->

                                        </div>
                                        <!--end::Info-->
                                        <!--begin::Subtitle-->
                                        <span class="text-gray-400 pt-1 fw-semibold fs-6">ارباح الشركة</span>
                                        <!--end::Subtitle-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-2 pb-4 d-flex flex-wrap align-items-center">
                                    <!--begin::Labels-->
                                    <div class="d-flex flex-column content-justify-center flex-row-fluid">
                                        <!--begin::Label-->
                                        <div class="d-flex fw-semibold align-items-center">
                                            <!--begin::Bullet-->
                                            <div class="bullet w-8px h-3px rounded-2 bg-success me-3"></div>
                                            <!--end::Bullet-->
                                            <!--begin::Label-->
                                            <div class="text-gray-500 flex-grow-1 me-4">ارباح البطاقات EVD</div>
                                            <!--end::Label-->
                                            <!--begin::Stats-->
                                            <div class="fw-bolder text-gray-700 text-xxl-end">SR {{  number_format(isset($orders) ? $orders->where('api_linked',1)->sum('merchant_price') -  $orders->where('api_linked',1)->sum('cost')  :  $statistics->api_mine_card_profits,2) }}</div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Label-->
                                        <div class="d-flex fw-semibold align-items-center my-3">
                                            <!--begin::Bullet-->
                                            <div class="bullet w-8px h-3px rounded-2 bg-primary me-3"></div>
                                            <!--end::Bullet-->
                                            <!--begin::Label-->
                                            <div class="text-gray-500 flex-grow-1 me-4">ارباح البطاقات الغير مربوطة</div>
                                            <!--end::Label-->
                                            <!--begin::Stats-->
                                            <div class="fw-bolder text-gray-700 text-xxl-end">SR {{ number_format(isset($orders) ? $orders->where('api_linked',0)->sum('merchant_price') -  $orders->where('api_linked',0)->sum('cost')  :  $statistics->not_mine_api_card_profits,2) }}</div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Labels-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card widget 17-->

                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10" >
                            <!--begin::Card widget 17-->
                            <div class="card card-flush h-md-50 mb-5 mb-xl-10" style="height:90% !important;">
                                <!--begin::Header-->
                                <div class="card-header pt-5">
                                    <!--begin::Title-->
                                    <div class="card-title d-flex flex-column">

                                        <!--begin::Subtitle-->
                                        <strong class="text-dark pt-1 fw-semibold ">المخزون</strong>
                                        <!--end::Subtitle-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-2 pb-4 d-flex flex-wrap align-items-center">
                                    <!--begin::Labels-->
                                    <div class="d-flex flex-column content-justify-center flex-row-fluid">
                                        <!--begin::Label-->
                                        <div class="d-flex fw-semibold align-items-center">
                                            <!--begin::Bullet-->
                                            <div class="bullet w-8px h-3px rounded-2 bg-success me-3"></div>
                                            <!--end::Bullet-->
                                            <!--begin::Label-->
                                            <div class="text-gray-500 flex-grow-1 me-4">عدد البطاقات</div>
                                            <!--end::Label-->
                                            <!--begin::Stats-->
                                            <div class="fw-bolder text-gray-700 text-xxl-end">{{  isset($orders) ? $orders->count()  : $statistics->card_numbers }}</div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Label-->
                                        <div class="d-flex fw-semibold align-items-center">
                                            <!--begin::Bullet-->
                                            <div class="bullet w-8px h-3px rounded-2 bg-success me-3"></div>
                                            <!--end::Bullet-->
                                            <!--begin::Label-->
                                            <div class="text-gray-500 flex-grow-1 me-4">اجمالي تكلفة البطاقات</div>
                                            <!--end::Label-->
                                            <!--begin::Stats-->
                                            <div class="fw-bolder text-gray-700 text-xxl-end">{{  number_format(isset($costs) ? $costs  : 0,2) }}</div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Label-->
                                        <div class="d-flex fw-semibold align-items-center my-3">
                                            <!--begin::Bullet-->
                                            <div class="bullet w-8px h-3px rounded-2 bg-primary me-3"></div>
                                            <!--end::Bullet-->
                                            <!--begin::Label-->
                                            <div class="text-gray-500 flex-grow-1 me-4">الرصيد الرقمي</div>
                                            <!--end::Label-->
                                            <!--begin::Stats-->
                                            <div class="fw-bolder text-gray-700 text-xxl-end">{{ number_format($statistics->digital_balance,2) }}</div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Label-->
                                        <div class="d-flex fw-semibold align-items-center my-3">
                                            <!--begin::Bullet-->
                                            <div class="bullet w-8px h-3px rounded-2 bg-primary me-3"></div>
                                            <!--end::Bullet-->
                                            <!--begin::Label-->
                                            <div class="text-gray-500 flex-grow-1 me-4">عمولة جيديا</div>
                                            <!--end::Label-->
                                            <!--begin::Stats-->
                                            <div class="fw-bolder text-gray-700 text-xxl-end">{{ number_format(isset($transfers) ?  $transfers->sum('geidea_commission') :$statistics->geidea_commission,2) }}</div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Label-->
                                        <div class="d-flex fw-semibold align-items-center my-3">
                                            <!--begin::Bullet-->
                                            <div class="bullet w-8px h-3px rounded-2 bg-primary me-3"></div>
                                            <!--end::Bullet-->
                                            <!--begin::Label-->
                                            <div class="text-gray-500 flex-grow-1 me-4">محفظة جيديا</div>
                                            <!--end::Label-->
                                            <!--begin::Stats-->
                                            <div class="fw-bolder text-gray-700 text-xxl-end">{{number_format( isset($geaida) ? $geaida :  $statistics->geidea_wallet,2) }}</div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Labels-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card widget 17-->

                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10" >
                            <!--begin::Card widget 17-->
                            <div class="card card-flush h-md-50 mb-5 mb-xl-10" style="height:90% !important;">
                                <!--begin::Header-->
                                <div class="card-header pt-5">
                                    <!--begin::Title-->
                                    <div class="card-title d-flex flex-column">

                                        <!--begin::Subtitle-->
                                        <strong class="text-dark pt-1 fw-semibold ">تكلفة المخزون</strong>
                                        <!--end::Subtitle-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-2 pb-4 d-flex flex-wrap align-items-center">
                                    <!--begin::Labels-->
                                    <div class="d-flex flex-column content-justify-center flex-row-fluid">

                                        <!--begin::Label-->
                                        <div class="d-flex fw-semibold align-items-center">
                                            <!--begin::Bullet-->
                                            <div class="bullet w-8px h-3px rounded-2 bg-success me-3"></div>
                                            <!--end::Bullet-->
                                            <!--begin::Label-->
                                            <div class="text-gray-500 flex-grow-1 me-4">اجمالي تكلفة البطاقات</div>
                                            <!--end::Label-->
                                            <!--begin::Stats-->
                                            <div class="fw-bolder text-gray-700 text-xxl-end">{{  number_format(isset($costs) ? $costs  : 0  , 2) }}</div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Label-->



                                    </div>
                                    <!--end::Labels-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card widget 17-->

                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10" >
                            <!--begin::Card widget 17-->
                            <div class="card card-flush h-md-50 mb-5 mb-xl-10" style="height:90% !important;">
                                <!--begin::Header-->
                                <div class="card-header pt-5">
                                    <!--begin::Title-->
                                    <div class="card-title d-flex flex-column">

                                        <!--begin::Subtitle-->
                                        <strong class="text-dark pt-1 fw-semibold ">اجمالي تكاليف المخزون</strong>
                                        <!--end::Subtitle-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-2 pb-4 d-flex flex-wrap align-items-center">
                                    <!--begin::Labels-->
                                    <div class="d-flex flex-column content-justify-center flex-row-fluid">

                                        <!--begin::Label-->
                                        <div class="d-flex fw-semibold align-items-center">
                                            <!--begin::Bullet-->
                                            <div class="bullet w-8px h-3px rounded-2 bg-success me-3"></div>
                                            <!--end::Bullet-->
                                            <!--begin::Label-->
                                            <div class="text-gray-500 flex-grow-1 me-4">اجمالي تكلفة البطاقات</div>
                                            <!--end::Label-->
                                            <!--begin::Stats-->
                                            <div class="fw-bolder text-gray-700 text-xxl-end">{{  number_format(isset($all_costs) ? $all_costs  : 0,2) }}</div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Label-->



                                    </div>
                                    <!--end::Labels-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card widget 17-->

                        </div>
                        <!--end::Col-->

                    </div>
                    <!--end::Row-->
                    <!--begin::Row-->
{{--                    <div class="row gx-5 gx-xl-10">--}}
{{--                        <!--begin::Col-->--}}
{{--                        <div class="col-xl-6 mb-5 mb-xl-10">--}}
{{--                            <!--begin::Tables widget 16-->--}}
{{--                            <div class="card card-flush h-xl-100">--}}
{{--                                <!--begin::Header-->--}}
{{--                                <div class="card-header pt-5">--}}
{{--                                    <!--begin::Title-->--}}
{{--                                    <h3 class="card-title align-items-start flex-column">--}}
{{--                                        <span class="card-label fw-bold text-gray-800">اعلى التجار مبيعا</span>--}}
{{--                                    </h3>--}}
{{--                                    <!--end::Title-->--}}
{{--                                    <!--begin::Toolbar-->--}}
{{--                                    <div class="card-toolbar">--}}
{{--                                        <!--begin::Menu-->--}}
{{--                                        <button class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">--}}
{{--                                            <!--begin::Svg Icon | path: icons/duotune/general/gen023.svg-->--}}
{{--                                            <span class="svg-icon svg-icon-1 svg-icon-gray-300 me-n1">--}}
{{--                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="4" fill="currentColor" />--}}
{{--                                                <rect x="11" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />--}}
{{--                                                <rect x="15" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />--}}
{{--                                                <rect x="7" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />--}}
{{--                                            </svg>--}}
{{--                                        </span>--}}
{{--                                            <!--end::Svg Icon-->--}}
{{--                                        </button>--}}
{{--                                        <!--begin::Menu 2-->--}}
{{--                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true">--}}
{{--                                            <!--begin::Menu item-->--}}
{{--                                            <div class="menu-item px-3">--}}
{{--                                                <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">البحث</div>--}}
{{--                                            </div>--}}
{{--                                            <!--end::Menu item-->--}}
{{--                                            <!--begin::Menu separator-->--}}
{{--                                            <div class="separator mb-3 opacity-75"></div>--}}
{{--                                            <!--end::Menu separator-->--}}
{{--                                            <form id="most_seller">--}}
{{--                                                <!--begin::Menu item-->--}}
{{--                                                <div class="menu-item px-3">--}}
{{--                                                    <!--begin::Row-->--}}
{{--                                                    <!--begin::Col-->--}}
{{--                                                    <label class="fs-6 form-label fw-bold text-dark">الفترة الزمنية</label>--}}
{{--                                                    <!--begin::Select-->--}}
{{--                                                    <select class="form-select form-select-solid" name="time" data-control="select2" data-placeholder="الفترة الزمنية" data-hide-search="true">--}}
{{--                                                        <option value=""></option>--}}
{{--                                                        <option value="current_month" {{ isset($time) && $time == "current_month" ? 'selected' : '' }} >الشهر الحالي</option>--}}
{{--                                                        <option value="3_month"  {{ isset($time) && $time == "3_month" ? 'selected' : '' }}>3 شهور</option>--}}
{{--                                                        <option value="exact_time" {{ isset($time) && $time == "exact_time" ? 'selected' : '' }}>فترة محددة</option>--}}
{{--                                                    </select>--}}
{{--                                                    <!--end::Select-->--}}
{{--                                                    <!--end::Col-->--}}


{{--                                                    <!--end::Row-->--}}
{{--                                                </div>--}}
{{--                                                <!--end::Menu item-->--}}
{{--                                                <!--begin::Menu separator-->--}}
{{--                                                <div class="separator mt-3 opacity-75"></div>--}}
{{--                                                <!--end::Menu separator-->--}}
{{--                                                <!--begin::Menu item-->--}}
{{--                                                <div class="menu-item px-3">--}}
{{--                                                    <!--begin::Col-->--}}
{{--                                                    <div id="from-div" style="@if(isset($from_date)) display: block; @else display: none; @endif" >--}}
{{--                                                        <label class="fs-6 form-label fw-bold text-dark">من</label>--}}
{{--                                                        <input type="date" class="form-control form-control form-control-solid" name="from_date" value="{{ isset($from_date) ? $from_date : null }}" />--}}

{{--                                                    </div>--}}
{{--                                                    <!--end::Col-->--}}

{{--                                                    <!--begin::Col-->--}}
{{--                                                    <div id="to-div" style="@if(isset($from_date)) display: block; @else display: none; @endif" >--}}
{{--                                                        <label class="fs-6 form-label fw-bold text-dark">الى</label>--}}
{{--                                                        <input type="date" class="form-control form-control form-control-solid" name="to_date" value="{{ isset($to_date) ? $to_date : null }}" />--}}

{{--                                                    </div>--}}
{{--                                                    <!--end::Col-->--}}
{{--                                                </div>--}}
{{--                                                <!--end::Menu item-->--}}

{{--                                                <!--begin::Menu item-->--}}
{{--                                                <div class="menu-item px-3">--}}
{{--                                                    <div class="menu-content px-3 py-3">--}}
{{--                                                        <button class="btn btn-primary btn-sm px-4" type="button" onclick="do_most_seller()">بحث</button>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <!--end::Menu item-->--}}
{{--                                            </form>--}}
{{--                                        </div>--}}
{{--                                        <!--end::Menu 2-->--}}
{{--                                        <!--end::Menu-->--}}
{{--                                    </div>--}}
{{--                                    <!--end::Toolbar-->--}}
{{--                                </div>--}}
{{--                                <!--end::Header-->--}}
{{--                                <!--begin::Body-->--}}
{{--                                <div class="card-body pt-6">--}}
{{--                                    <!--begin::Tab Content-->--}}
{{--                                    <div class="tab-content">--}}
{{--                                        <!--begin::Tap pane-->--}}
{{--                                        <div class="tab-pane fade show active" id="kt_stats_widget_16_tab_1">--}}
{{--                                            <!--begin::Table container-->--}}
{{--                                            <div class="table-responsive">--}}
{{--                                                <!--begin::Table-->--}}
{{--                                                <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">--}}
{{--                                                    <!--begin::Table head-->--}}
{{--                                                    <thead>--}}
{{--                                                    <tr class="fs-7 fw-bold text-gray-400 border-bottom-0">--}}
{{--                                                        <th class="p-0 pb-3 min-w-150px text-start">اسم التاجر</th>--}}
{{--                                                        <th class="p-0 pb-3 min-w-100px ">عدد المبيعات</th>--}}
{{--                                                        <th class="p-0 pb-3 w-125px ">اجمالي المبيعات</th>--}}
{{--                                                        <th class="p-0 pb-3 w-50px text-end">اجمالي الارباح</th>--}}
{{--                                                    </tr>--}}
{{--                                                    </thead>--}}
{{--                                                    <!--end::Table head-->--}}
{{--                                                    <!--begin::Table body-->--}}
{{--                                                    <tbody id="get_most_seller">--}}
{{--                                                    @include('admin.dashboard._seller')--}}
{{--                                                    </tbody>--}}
{{--                                                    <!--end::Table body-->--}}
{{--                                                </table>--}}
{{--                                                <!--end::Table-->--}}
{{--                                            </div>--}}
{{--                                            <!--end::Table container-->--}}
{{--                                        </div>--}}
{{--                                        <!--end::Tap pane-->--}}

{{--                                        <!--end::Table container-->--}}
{{--                                    </div>--}}
{{--                                    <!--end::Tab Content-->--}}
{{--                                </div>--}}
{{--                                <!--end: Card Body-->--}}
{{--                            </div>--}}
{{--                            <!--end::Tables widget 16-->--}}
{{--                        </div>--}}
{{--                        <!--end::Col-->--}}
{{--                        <!--begin::Col-->--}}
{{--                        <div class="col-xl-6 mb-5 mb-xl-10">--}}
{{--                            <!--begin::Tables widget 16-->--}}
{{--                            <div class="card card-flush h-xl-100">--}}
{{--                                <!--begin::Header-->--}}
{{--                                <div class="card-header pt-5">--}}
{{--                                    <!--begin::Title-->--}}
{{--                                    <h3 class="card-title align-items-start flex-column">--}}
{{--                                        <span class="card-label fw-bold text-gray-800">اقل التجار نشاطا</span>--}}
{{--                                    </h3>--}}
{{--                                    <!--end::Title-->--}}
{{--                                    <!--begin::Toolbar-->--}}
{{--                                    <div class="card-toolbar">--}}
{{--                                        <!--begin::Menu-->--}}
{{--                                        <button class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">--}}
{{--                                            <!--begin::Svg Icon | path: icons/duotune/general/gen023.svg-->--}}
{{--                                            <span class="svg-icon svg-icon-1 svg-icon-gray-300 me-n1">--}}
{{--                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="4" fill="currentColor" />--}}
{{--                                                <rect x="11" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />--}}
{{--                                                <rect x="15" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />--}}
{{--                                                <rect x="7" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />--}}
{{--                                            </svg>--}}
{{--                                        </span>--}}
{{--                                            <!--end::Svg Icon-->--}}
{{--                                        </button>--}}
{{--                                        <!--begin::Menu 2-->--}}
{{--                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true">--}}
{{--                                            <!--begin::Menu item-->--}}
{{--                                            <div class="menu-item px-3">--}}
{{--                                                <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">البحث</div>--}}
{{--                                            </div>--}}
{{--                                            <!--end::Menu item-->--}}
{{--                                            <!--begin::Menu separator-->--}}
{{--                                            <div class="separator mb-3 opacity-75"></div>--}}
{{--                                            <!--end::Menu separator-->--}}
{{--                                            <form id="lowest_seller">--}}
{{--                                                <!--begin::Menu item-->--}}
{{--                                                <div class="menu-item px-3">--}}
{{--                                                    <!--begin::Row-->--}}
{{--                                                    <!--begin::Col-->--}}
{{--                                                    <label class="fs-6 form-label fw-bold text-dark">الفترة الزمنية</label>--}}
{{--                                                    <!--begin::Select-->--}}
{{--                                                    <select class="form-select form-select-solid" id="seller_time" name="time" data-control="select2" data-placeholder="الفترة الزمنية" data-hide-search="true">--}}
{{--                                                        <option value=""></option>--}}
{{--                                                        <option value="current_month" {{ isset($time) && $time == "current_month" ? 'selected' : '' }} >الشهر الحالي</option>--}}
{{--                                                        <option value="3_month"  {{ isset($time) && $time == "3_month" ? 'selected' : '' }}>3 شهور</option>--}}
{{--                                                        <option value="exact_time" {{ isset($time) && $time == "exact_time" ? 'selected' : '' }}>فترة محددة</option>--}}
{{--                                                    </select>--}}
{{--                                                    <!--end::Select-->--}}
{{--                                                    <!--end::Col-->--}}


{{--                                                    <!--end::Row-->--}}
{{--                                                </div>--}}
{{--                                                <!--end::Menu item-->--}}
{{--                                                <!--begin::Menu separator-->--}}
{{--                                                <div class="separator mt-3 opacity-75"></div>--}}
{{--                                                <!--end::Menu separator-->--}}
{{--                                                <!--begin::Menu item-->--}}
{{--                                                <div class="menu-item px-3">--}}
{{--                                                    <!--begin::Col-->--}}
{{--                                                    <div id="from-seller-div" style="@if(isset($from_date)) display: block; @else display: none; @endif" >--}}
{{--                                                        <label class="fs-6 form-label fw-bold text-dark">من</label>--}}
{{--                                                        <input type="date" class="form-control form-control form-control-solid" name="from_date" value="{{ isset($from_date) ? $from_date : null }}" />--}}

{{--                                                    </div>--}}
{{--                                                    <!--end::Col-->--}}

{{--                                                    <!--begin::Col-->--}}
{{--                                                    <div id="to-seller-div" style="@if(isset($from_date)) display: block; @else display: none; @endif" >--}}
{{--                                                        <label class="fs-6 form-label fw-bold text-dark">الى</label>--}}
{{--                                                        <input type="date" class="form-control form-control form-control-solid" name="to_date" value="{{ isset($to_date) ? $to_date : null }}" />--}}

{{--                                                    </div>--}}
{{--                                                    <!--end::Col-->--}}
{{--                                                </div>--}}
{{--                                                <!--end::Menu item-->--}}

{{--                                                <!--begin::Menu item-->--}}
{{--                                                <div class="menu-item px-3">--}}
{{--                                                    <div class="menu-content px-3 py-3">--}}
{{--                                                        <button class="btn btn-primary btn-sm px-4" type="button" onclick="do_lowest_seller()">بحث</button>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <!--end::Menu item-->--}}
{{--                                            </form>--}}
{{--                                        </div>--}}
{{--                                        <!--end::Menu 2-->--}}
{{--                                        <!--end::Menu-->--}}
{{--                                    </div>--}}
{{--                                    <!--end::Toolbar-->--}}
{{--                                </div>--}}
{{--                                <!--end::Header-->--}}
{{--                                <!--begin::Body-->--}}
{{--                                <div class="card-body pt-6">--}}

{{--                                    <!--begin::Tab Content-->--}}
{{--                                    <div class="tab-content">--}}
{{--                                        <!--begin::Tap pane-->--}}
{{--                                        <div class="tab-pane fade show active" id="kt_stats_widget_16_tab_1">--}}
{{--                                            <!--begin::Table container-->--}}
{{--                                            <div class="table-responsive">--}}
{{--                                                <!--begin::Table-->--}}
{{--                                                <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">--}}
{{--                                                    <!--begin::Table head-->--}}
{{--                                                    <thead>--}}
{{--                                                    <tr class="fs-7 fw-bold text-gray-400 border-bottom-0">--}}
{{--                                                        <th class="p-0 pb-3 min-w-150px text-start">اسم التاجر</th>--}}
{{--                                                        <th class="p-0 pb-3 min-w-100px ">عدد المبيعات</th>--}}
{{--                                                        <th class="p-0 pb-3 w-125px ">اجمالي المبيعات</th>--}}
{{--                                                        <th class="p-0 pb-3 w-50px text-end">اجمالي الارباح</th>--}}
{{--                                                    </tr>--}}
{{--                                                    </thead>--}}
{{--                                                    <!--end::Table head-->--}}
{{--                                                    <!--begin::Table body-->--}}
{{--                                                    <tbody id="get_lowest_seller">--}}
{{--                                                    @include('admin.dashboard._lowest_seller')--}}

{{--                                                    </tbody>--}}
{{--                                                    <!--end::Table body-->--}}
{{--                                                </table>--}}
{{--                                                <!--end::Table-->--}}
{{--                                            </div>--}}
{{--                                            <!--end::Table container-->--}}
{{--                                        </div>--}}
{{--                                        <!--end::Tap pane-->--}}
{{--                                        <!--begin::Tap pane-->--}}
{{--                                        <div class="tab-pane fade" id="kt_stats_widget_16_tab_2">--}}
{{--                                            <!--begin::Table container-->--}}
{{--                                            <div class="table-responsive">--}}
{{--                                                <!--begin::Table-->--}}
{{--                                                <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">--}}
{{--                                                    <!--begin::Table head-->--}}
{{--                                                    <thead>--}}
{{--                                                    <tr class="fs-7 fw-bold text-gray-400 border-bottom-0">--}}
{{--                                                        <th class="p-0 pb-3 min-w-150px text-start">AUTHOR</th>--}}
{{--                                                        <th class="p-0 pb-3 min-w-100px text-end pe-13">CONV.</th>--}}
{{--                                                        <th class="p-0 pb-3 w-125px text-end pe-7">CHART</th>--}}
{{--                                                        <th class="p-0 pb-3 w-50px text-end">VIEW</th>--}}
{{--                                                    </tr>--}}
{{--                                                    </thead>--}}
{{--                                                    <!--end::Table head-->--}}
{{--                                                    <!--begin::Table body-->--}}
{{--                                                    <tbody>--}}
{{--                                                    <tr>--}}
{{--                                                        <td>--}}
{{--                                                            <div class="d-flex align-items-center">--}}
{{--                                                                <div class="symbol symbol-50px me-3">--}}
{{--                                                                    <img src="assets/media/avatars/300-25.jpg" class="" alt="" />--}}
{{--                                                                </div>--}}
{{--                                                                <div class="d-flex justify-content-start flex-column">--}}
{{--                                                                    <a href="../../demo1/dist/pages/user-profile/overview.html" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">Brooklyn Simmons</a>--}}
{{--                                                                    <span class="text-gray-400 fw-semibold d-block fs-7">Poland</span>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-13">--}}
{{--                                                            <span class="text-gray-600 fw-bold fs-6">85.23%</span>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-0">--}}
{{--                                                            <div id="kt_table_widget_16_chart_2_1" class="h-50px mt-n8 pe-7" data-kt-chart-color="success"></div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end">--}}
{{--                                                            <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">--}}
{{--                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->--}}
{{--                                                                <span class="svg-icon svg-icon-5 svg-icon-gray-700">--}}
{{--																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--																							<path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="currentColor" />--}}
{{--																							<path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="currentColor" />--}}
{{--																						</svg>--}}
{{--																					</span>--}}
{{--                                                                <!--end::Svg Icon-->--}}
{{--                                                            </a>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    <tr>--}}
{{--                                                        <td>--}}
{{--                                                            <div class="d-flex align-items-center">--}}
{{--                                                                <div class="symbol symbol-50px me-3">--}}
{{--                                                                    <img src="assets/media/avatars/300-24.jpg" class="" alt="" />--}}
{{--                                                                </div>--}}
{{--                                                                <div class="d-flex justify-content-start flex-column">--}}
{{--                                                                    <a href="../../demo1/dist/pages/user-profile/overview.html" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">Esther Howard</a>--}}
{{--                                                                    <span class="text-gray-400 fw-semibold d-block fs-7">Mexico</span>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-13">--}}
{{--                                                            <span class="text-gray-600 fw-bold fs-6">74.83%</span>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-0">--}}
{{--                                                            <div id="kt_table_widget_16_chart_2_2" class="h-50px mt-n8 pe-7" data-kt-chart-color="danger"></div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end">--}}
{{--                                                            <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">--}}
{{--                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->--}}
{{--                                                                <span class="svg-icon svg-icon-5 svg-icon-gray-700">--}}
{{--																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--																							<path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="currentColor" />--}}
{{--																							<path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="currentColor" />--}}
{{--																						</svg>--}}
{{--																					</span>--}}
{{--                                                                <!--end::Svg Icon-->--}}
{{--                                                            </a>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    <tr>--}}
{{--                                                        <td>--}}
{{--                                                            <div class="d-flex align-items-center">--}}
{{--                                                                <div class="symbol symbol-50px me-3">--}}
{{--                                                                    <img src="assets/media/avatars/300-20.jpg" class="" alt="" />--}}
{{--                                                                </div>--}}
{{--                                                                <div class="d-flex justify-content-start flex-column">--}}
{{--                                                                    <a href="../../demo1/dist/pages/user-profile/overview.html" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">Annette Black</a>--}}
{{--                                                                    <span class="text-gray-400 fw-semibold d-block fs-7">Haiti</span>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-13">--}}
{{--                                                            <span class="text-gray-600 fw-bold fs-6">90.06%</span>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-0">--}}
{{--                                                            <div id="kt_table_widget_16_chart_2_3" class="h-50px mt-n8 pe-7" data-kt-chart-color="success"></div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end">--}}
{{--                                                            <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">--}}
{{--                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->--}}
{{--                                                                <span class="svg-icon svg-icon-5 svg-icon-gray-700">--}}
{{--																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--																							<path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="currentColor" />--}}
{{--																							<path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="currentColor" />--}}
{{--																						</svg>--}}
{{--																					</span>--}}
{{--                                                                <!--end::Svg Icon-->--}}
{{--                                                            </a>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    <tr>--}}
{{--                                                        <td>--}}
{{--                                                            <div class="d-flex align-items-center">--}}
{{--                                                                <div class="symbol symbol-50px me-3">--}}
{{--                                                                    <img src="assets/media/avatars/300-17.jpg" class="" alt="" />--}}
{{--                                                                </div>--}}
{{--                                                                <div class="d-flex justify-content-start flex-column">--}}
{{--                                                                    <a href="../../demo1/dist/pages/user-profile/overview.html" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">Marvin McKinney</a>--}}
{{--                                                                    <span class="text-gray-400 fw-semibold d-block fs-7">Monaco</span>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-13">--}}
{{--                                                            <span class="text-gray-600 fw-bold fs-6">54.08%</span>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-0">--}}
{{--                                                            <div id="kt_table_widget_16_chart_2_4" class="h-50px mt-n8 pe-7" data-kt-chart-color="success"></div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end">--}}
{{--                                                            <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">--}}
{{--                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->--}}
{{--                                                                <span class="svg-icon svg-icon-5 svg-icon-gray-700">--}}
{{--																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--																							<path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="currentColor" />--}}
{{--																							<path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="currentColor" />--}}
{{--																						</svg>--}}
{{--																					</span>--}}
{{--                                                                <!--end::Svg Icon-->--}}
{{--                                                            </a>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    </tbody>--}}
{{--                                                    <!--end::Table body-->--}}
{{--                                                </table>--}}
{{--                                                <!--end::Table-->--}}
{{--                                            </div>--}}
{{--                                            <!--end::Table container-->--}}
{{--                                        </div>--}}
{{--                                        <!--end::Tap pane-->--}}
{{--                                        <!--begin::Tap pane-->--}}
{{--                                        <div class="tab-pane fade" id="kt_stats_widget_16_tab_3">--}}
{{--                                            <!--begin::Table container-->--}}
{{--                                            <div class="table-responsive">--}}
{{--                                                <!--begin::Table-->--}}
{{--                                                <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">--}}
{{--                                                    <!--begin::Table head-->--}}
{{--                                                    <thead>--}}
{{--                                                    <tr class="fs-7 fw-bold text-gray-400 border-bottom-0">--}}
{{--                                                        <th class="p-0 pb-3 min-w-150px text-start">AUTHOR</th>--}}
{{--                                                        <th class="p-0 pb-3 min-w-100px text-end pe-13">CONV.</th>--}}
{{--                                                        <th class="p-0 pb-3 w-125px text-end pe-7">CHART</th>--}}
{{--                                                        <th class="p-0 pb-3 w-50px text-end">VIEW</th>--}}
{{--                                                    </tr>--}}
{{--                                                    </thead>--}}
{{--                                                    <!--end::Table head-->--}}
{{--                                                    <!--begin::Table body-->--}}
{{--                                                    <tbody>--}}
{{--                                                    <tr>--}}
{{--                                                        <td>--}}
{{--                                                            <div class="d-flex align-items-center">--}}
{{--                                                                <div class="symbol symbol-50px me-3">--}}
{{--                                                                    <img src="assets/media/avatars/300-11.jpg" class="" alt="" />--}}
{{--                                                                </div>--}}
{{--                                                                <div class="d-flex justify-content-start flex-column">--}}
{{--                                                                    <a href="../../demo1/dist/pages/user-profile/overview.html" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">Jacob Jones</a>--}}
{{--                                                                    <span class="text-gray-400 fw-semibold d-block fs-7">New York</span>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-13">--}}
{{--                                                            <span class="text-gray-600 fw-bold fs-6">52.34%</span>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-0">--}}
{{--                                                            <div id="kt_table_widget_16_chart_3_1" class="h-50px mt-n8 pe-7" data-kt-chart-color="success"></div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end">--}}
{{--                                                            <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">--}}
{{--                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->--}}
{{--                                                                <span class="svg-icon svg-icon-5 svg-icon-gray-700">--}}
{{--																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--																							<path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="currentColor" />--}}
{{--																							<path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="currentColor" />--}}
{{--																						</svg>--}}
{{--																					</span>--}}
{{--                                                                <!--end::Svg Icon-->--}}
{{--                                                            </a>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    <tr>--}}
{{--                                                        <td>--}}
{{--                                                            <div class="d-flex align-items-center">--}}
{{--                                                                <div class="symbol symbol-50px me-3">--}}
{{--                                                                    <img src="assets/media/avatars/300-23.jpg" class="" alt="" />--}}
{{--                                                                </div>--}}
{{--                                                                <div class="d-flex justify-content-start flex-column">--}}
{{--                                                                    <a href="../../demo1/dist/pages/user-profile/overview.html" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">Ronald Richards</a>--}}
{{--                                                                    <span class="text-gray-400 fw-semibold d-block fs-7">Madrid</span>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-13">--}}
{{--                                                            <span class="text-gray-600 fw-bold fs-6">77.65%</span>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-0">--}}
{{--                                                            <div id="kt_table_widget_16_chart_3_2" class="h-50px mt-n8 pe-7" data-kt-chart-color="danger"></div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end">--}}
{{--                                                            <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">--}}
{{--                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->--}}
{{--                                                                <span class="svg-icon svg-icon-5 svg-icon-gray-700">--}}
{{--																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--																							<path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="currentColor" />--}}
{{--																							<path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="currentColor" />--}}
{{--																						</svg>--}}
{{--																					</span>--}}
{{--                                                                <!--end::Svg Icon-->--}}
{{--                                                            </a>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    <tr>--}}
{{--                                                        <td>--}}
{{--                                                            <div class="d-flex align-items-center">--}}
{{--                                                                <div class="symbol symbol-50px me-3">--}}
{{--                                                                    <img src="assets/media/avatars/300-4.jpg" class="" alt="" />--}}
{{--                                                                </div>--}}
{{--                                                                <div class="d-flex justify-content-start flex-column">--}}
{{--                                                                    <a href="../../demo1/dist/pages/user-profile/overview.html" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">Leslie Alexander</a>--}}
{{--                                                                    <span class="text-gray-400 fw-semibold d-block fs-7">Pune</span>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-13">--}}
{{--                                                            <span class="text-gray-600 fw-bold fs-6">82.47%</span>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-0">--}}
{{--                                                            <div id="kt_table_widget_16_chart_3_3" class="h-50px mt-n8 pe-7" data-kt-chart-color="success"></div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end">--}}
{{--                                                            <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">--}}
{{--                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->--}}
{{--                                                                <span class="svg-icon svg-icon-5 svg-icon-gray-700">--}}
{{--																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--																							<path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="currentColor" />--}}
{{--																							<path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="currentColor" />--}}
{{--																						</svg>--}}
{{--																					</span>--}}
{{--                                                                <!--end::Svg Icon-->--}}
{{--                                                            </a>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    <tr>--}}
{{--                                                        <td>--}}
{{--                                                            <div class="d-flex align-items-center">--}}
{{--                                                                <div class="symbol symbol-50px me-3">--}}
{{--                                                                    <img src="assets/media/avatars/300-1.jpg" class="" alt="" />--}}
{{--                                                                </div>--}}
{{--                                                                <div class="d-flex justify-content-start flex-column">--}}
{{--                                                                    <a href="../../demo1/dist/pages/user-profile/overview.html" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">Courtney Henry</a>--}}
{{--                                                                    <span class="text-gray-400 fw-semibold d-block fs-7">Mexico</span>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-13">--}}
{{--                                                            <span class="text-gray-600 fw-bold fs-6">67.84%</span>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-0">--}}
{{--                                                            <div id="kt_table_widget_16_chart_3_4" class="h-50px mt-n8 pe-7" data-kt-chart-color="success"></div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end">--}}
{{--                                                            <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">--}}
{{--                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->--}}
{{--                                                                <span class="svg-icon svg-icon-5 svg-icon-gray-700">--}}
{{--																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--																							<path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="currentColor" />--}}
{{--																							<path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="currentColor" />--}}
{{--																						</svg>--}}
{{--																					</span>--}}
{{--                                                                <!--end::Svg Icon-->--}}
{{--                                                            </a>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    </tbody>--}}
{{--                                                    <!--end::Table body-->--}}
{{--                                                </table>--}}
{{--                                                <!--end::Table-->--}}
{{--                                            </div>--}}
{{--                                            <!--end::Table container-->--}}
{{--                                        </div>--}}
{{--                                        <!--end::Tap pane-->--}}
{{--                                        <!--begin::Tap pane-->--}}
{{--                                        <div class="tab-pane fade" id="kt_stats_widget_16_tab_4">--}}
{{--                                            <!--begin::Table container-->--}}
{{--                                            <div class="table-responsive">--}}
{{--                                                <!--begin::Table-->--}}
{{--                                                <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">--}}
{{--                                                    <!--begin::Table head-->--}}
{{--                                                    <thead>--}}
{{--                                                    <tr class="fs-7 fw-bold text-gray-400 border-bottom-0">--}}
{{--                                                        <th class="p-0 pb-3 min-w-150px text-start">AUTHOR</th>--}}
{{--                                                        <th class="p-0 pb-3 min-w-100px text-end pe-13">CONV.</th>--}}
{{--                                                        <th class="p-0 pb-3 w-125px text-end pe-7">CHART</th>--}}
{{--                                                        <th class="p-0 pb-3 w-50px text-end">VIEW</th>--}}
{{--                                                    </tr>--}}
{{--                                                    </thead>--}}
{{--                                                    <!--end::Table head-->--}}
{{--                                                    <!--begin::Table body-->--}}
{{--                                                    <tbody>--}}
{{--                                                    <tr>--}}
{{--                                                        <td>--}}
{{--                                                            <div class="d-flex align-items-center">--}}
{{--                                                                <div class="symbol symbol-50px me-3">--}}
{{--                                                                    <img src="assets/media/avatars/300-12.jpg" class="" alt="" />--}}
{{--                                                                </div>--}}
{{--                                                                <div class="d-flex justify-content-start flex-column">--}}
{{--                                                                    <a href="../../demo1/dist/pages/user-profile/overview.html" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">Arlene McCoy</a>--}}
{{--                                                                    <span class="text-gray-400 fw-semibold d-block fs-7">London</span>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-13">--}}
{{--                                                            <span class="text-gray-600 fw-bold fs-6">53.44%</span>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-0">--}}
{{--                                                            <div id="kt_table_widget_16_chart_4_1" class="h-50px mt-n8 pe-7" data-kt-chart-color="success"></div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end">--}}
{{--                                                            <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">--}}
{{--                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->--}}
{{--                                                                <span class="svg-icon svg-icon-5 svg-icon-gray-700">--}}
{{--																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--																							<path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="currentColor" />--}}
{{--																							<path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="currentColor" />--}}
{{--																						</svg>--}}
{{--																					</span>--}}
{{--                                                                <!--end::Svg Icon-->--}}
{{--                                                            </a>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    <tr>--}}
{{--                                                        <td>--}}
{{--                                                            <div class="d-flex align-items-center">--}}
{{--                                                                <div class="symbol symbol-50px me-3">--}}
{{--                                                                    <img src="assets/media/avatars/300-21.jpg" class="" alt="" />--}}
{{--                                                                </div>--}}
{{--                                                                <div class="d-flex justify-content-start flex-column">--}}
{{--                                                                    <a href="../../demo1/dist/pages/user-profile/overview.html" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">Marvin McKinneyr</a>--}}
{{--                                                                    <span class="text-gray-400 fw-semibold d-block fs-7">Monaco</span>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-13">--}}
{{--                                                            <span class="text-gray-600 fw-bold fs-6">74.64%</span>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-0">--}}
{{--                                                            <div id="kt_table_widget_16_chart_4_2" class="h-50px mt-n8 pe-7" data-kt-chart-color="danger"></div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end">--}}
{{--                                                            <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">--}}
{{--                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->--}}
{{--                                                                <span class="svg-icon svg-icon-5 svg-icon-gray-700">--}}
{{--																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--																							<path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="currentColor" />--}}
{{--																							<path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="currentColor" />--}}
{{--																						</svg>--}}
{{--																					</span>--}}
{{--                                                                <!--end::Svg Icon-->--}}
{{--                                                            </a>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    <tr>--}}
{{--                                                        <td>--}}
{{--                                                            <div class="d-flex align-items-center">--}}
{{--                                                                <div class="symbol symbol-50px me-3">--}}
{{--                                                                    <img src="assets/media/avatars/300-30.jpg" class="" alt="" />--}}
{{--                                                                </div>--}}
{{--                                                                <div class="d-flex justify-content-start flex-column">--}}
{{--                                                                    <a href="../../demo1/dist/pages/user-profile/overview.html" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">Jacob Jones</a>--}}
{{--                                                                    <span class="text-gray-400 fw-semibold d-block fs-7">PManila</span>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-13">--}}
{{--                                                            <span class="text-gray-600 fw-bold fs-6">88.56%</span>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-0">--}}
{{--                                                            <div id="kt_table_widget_16_chart_4_3" class="h-50px mt-n8 pe-7" data-kt-chart-color="success"></div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end">--}}
{{--                                                            <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">--}}
{{--                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->--}}
{{--                                                                <span class="svg-icon svg-icon-5 svg-icon-gray-700">--}}
{{--																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--																							<path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="currentColor" />--}}
{{--																							<path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="currentColor" />--}}
{{--																						</svg>--}}
{{--																					</span>--}}
{{--                                                                <!--end::Svg Icon-->--}}
{{--                                                            </a>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    <tr>--}}
{{--                                                        <td>--}}
{{--                                                            <div class="d-flex align-items-center">--}}
{{--                                                                <div class="symbol symbol-50px me-3">--}}
{{--                                                                    <img src="assets/media/avatars/300-14.jpg" class="" alt="" />--}}
{{--                                                                </div>--}}
{{--                                                                <div class="d-flex justify-content-start flex-column">--}}
{{--                                                                    <a href="../../demo1/dist/pages/user-profile/overview.html" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">Esther Howard</a>--}}
{{--                                                                    <span class="text-gray-400 fw-semibold d-block fs-7">Iceland</span>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-13">--}}
{{--                                                            <span class="text-gray-600 fw-bold fs-6">63.16%</span>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-0">--}}
{{--                                                            <div id="kt_table_widget_16_chart_4_4" class="h-50px mt-n8 pe-7" data-kt-chart-color="success"></div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end">--}}
{{--                                                            <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">--}}
{{--                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->--}}
{{--                                                                <span class="svg-icon svg-icon-5 svg-icon-gray-700">--}}
{{--																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--																							<path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="currentColor" />--}}
{{--																							<path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="currentColor" />--}}
{{--																						</svg>--}}
{{--																					</span>--}}
{{--                                                                <!--end::Svg Icon-->--}}
{{--                                                            </a>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    </tbody>--}}
{{--                                                    <!--end::Table body-->--}}
{{--                                                </table>--}}
{{--                                                <!--end::Table-->--}}
{{--                                            </div>--}}
{{--                                            <!--end::Table container-->--}}
{{--                                        </div>--}}
{{--                                        <!--end::Tap pane-->--}}
{{--                                        <!--begin::Tap pane-->--}}
{{--                                        <div class="tab-pane fade" id="kt_stats_widget_16_tab_5">--}}
{{--                                            <!--begin::Table container-->--}}
{{--                                            <div class="table-responsive">--}}
{{--                                                <!--begin::Table-->--}}
{{--                                                <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">--}}
{{--                                                    <!--begin::Table head-->--}}
{{--                                                    <thead>--}}
{{--                                                    <tr class="fs-7 fw-bold text-gray-400 border-bottom-0">--}}
{{--                                                        <th class="p-0 pb-3 min-w-150px text-start">AUTHOR</th>--}}
{{--                                                        <th class="p-0 pb-3 min-w-100px text-end pe-13">CONV.</th>--}}
{{--                                                        <th class="p-0 pb-3 w-125px text-end pe-7">CHART</th>--}}
{{--                                                        <th class="p-0 pb-3 w-50px text-end">VIEW</th>--}}
{{--                                                    </tr>--}}
{{--                                                    </thead>--}}
{{--                                                    <!--end::Table head-->--}}
{{--                                                    <!--begin::Table body-->--}}
{{--                                                    <tbody>--}}
{{--                                                    <tr>--}}
{{--                                                        <td>--}}
{{--                                                            <div class="d-flex align-items-center">--}}
{{--                                                                <div class="symbol symbol-50px me-3">--}}
{{--                                                                    <img src="assets/media/avatars/300-6.jpg" class="" alt="" />--}}
{{--                                                                </div>--}}
{{--                                                                <div class="d-flex justify-content-start flex-column">--}}
{{--                                                                    <a href="../../demo1/dist/pages/user-profile/overview.html" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">Jane Cooper</a>--}}
{{--                                                                    <span class="text-gray-400 fw-semibold d-block fs-7">Haiti</span>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-13">--}}
{{--                                                            <span class="text-gray-600 fw-bold fs-6">68.54%</span>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-0">--}}
{{--                                                            <div id="kt_table_widget_16_chart_5_1" class="h-50px mt-n8 pe-7" data-kt-chart-color="success"></div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end">--}}
{{--                                                            <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">--}}
{{--                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->--}}
{{--                                                                <span class="svg-icon svg-icon-5 svg-icon-gray-700">--}}
{{--																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--																							<path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="currentColor" />--}}
{{--																							<path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="currentColor" />--}}
{{--																						</svg>--}}
{{--																					</span>--}}
{{--                                                                <!--end::Svg Icon-->--}}
{{--                                                            </a>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    <tr>--}}
{{--                                                        <td>--}}
{{--                                                            <div class="d-flex align-items-center">--}}
{{--                                                                <div class="symbol symbol-50px me-3">--}}
{{--                                                                    <img src="assets/media/avatars/300-10.jpg" class="" alt="" />--}}
{{--                                                                </div>--}}
{{--                                                                <div class="d-flex justify-content-start flex-column">--}}
{{--                                                                    <a href="../../demo1/dist/pages/user-profile/overview.html" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">Esther Howard</a>--}}
{{--                                                                    <span class="text-gray-400 fw-semibold d-block fs-7">Kiribati</span>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-13">--}}
{{--                                                            <span class="text-gray-600 fw-bold fs-6">55.83%</span>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-0">--}}
{{--                                                            <div id="kt_table_widget_16_chart_5_2" class="h-50px mt-n8 pe-7" data-kt-chart-color="danger"></div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end">--}}
{{--                                                            <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">--}}
{{--                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->--}}
{{--                                                                <span class="svg-icon svg-icon-5 svg-icon-gray-700">--}}
{{--																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--																							<path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="currentColor" />--}}
{{--																							<path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="currentColor" />--}}
{{--																						</svg>--}}
{{--																					</span>--}}
{{--                                                                <!--end::Svg Icon-->--}}
{{--                                                            </a>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    <tr>--}}
{{--                                                        <td>--}}
{{--                                                            <div class="d-flex align-items-center">--}}
{{--                                                                <div class="symbol symbol-50px me-3">--}}
{{--                                                                    <img src="assets/media/avatars/300-9.jpg" class="" alt="" />--}}
{{--                                                                </div>--}}
{{--                                                                <div class="d-flex justify-content-start flex-column">--}}
{{--                                                                    <a href="../../demo1/dist/pages/user-profile/overview.html" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">Jacob Jones</a>--}}
{{--                                                                    <span class="text-gray-400 fw-semibold d-block fs-7">Poland</span>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-13">--}}
{{--                                                            <span class="text-gray-600 fw-bold fs-6">93.46%</span>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-0">--}}
{{--                                                            <div id="kt_table_widget_16_chart_5_3" class="h-50px mt-n8 pe-7" data-kt-chart-color="success"></div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end">--}}
{{--                                                            <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">--}}
{{--                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->--}}
{{--                                                                <span class="svg-icon svg-icon-5 svg-icon-gray-700">--}}
{{--																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--																							<path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="currentColor" />--}}
{{--																							<path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="currentColor" />--}}
{{--																						</svg>--}}
{{--																					</span>--}}
{{--                                                                <!--end::Svg Icon-->--}}
{{--                                                            </a>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    <tr>--}}
{{--                                                        <td>--}}
{{--                                                            <div class="d-flex align-items-center">--}}
{{--                                                                <div class="symbol symbol-50px me-3">--}}
{{--                                                                    <img src="assets/media/avatars/300-3.jpg" class="" alt="" />--}}
{{--                                                                </div>--}}
{{--                                                                <div class="d-flex justify-content-start flex-column">--}}
{{--                                                                    <a href="../../demo1/dist/pages/user-profile/overview.html" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">Ralph Edwards</a>--}}
{{--                                                                    <span class="text-gray-400 fw-semibold d-block fs-7">Mexico</span>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-13">--}}
{{--                                                            <span class="text-gray-600 fw-bold fs-6">64.48%</span>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end pe-0">--}}
{{--                                                            <div id="kt_table_widget_16_chart_5_4" class="h-50px mt-n8 pe-7" data-kt-chart-color="success"></div>--}}
{{--                                                        </td>--}}
{{--                                                        <td class="text-end">--}}
{{--                                                            <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">--}}
{{--                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr001.svg-->--}}
{{--                                                                <span class="svg-icon svg-icon-5 svg-icon-gray-700">--}}
{{--																						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--																							<path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="currentColor" />--}}
{{--																							<path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z" fill="currentColor" />--}}
{{--																						</svg>--}}
{{--																					</span>--}}
{{--                                                                <!--end::Svg Icon-->--}}
{{--                                                            </a>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                    </tbody>--}}
{{--                                                    <!--end::Table body-->--}}
{{--                                                </table>--}}
{{--                                                <!--end::Table-->--}}
{{--                                            </div>--}}
{{--                                            <!--end::Table container-->--}}
{{--                                        </div>--}}
{{--                                        <!--end::Tap pane-->--}}
{{--                                        <!--end::Table container-->--}}
{{--                                    </div>--}}
{{--                                    <!--end::Tab Content-->--}}
{{--                                </div>--}}
{{--                                <!--end: Card Body-->--}}
{{--                            </div>--}}
{{--                            <!--end::Tables widget 16-->--}}
{{--                        </div>--}}
{{--                        <!--end::Col-->--}}
{{--                    </div>--}}
                    <!--end::Row-->
                </div>
                <!--end::Content container-->
                <!--begin::Content container-->

            </div>
            <!--end::Content-->
        </div>
        <!--end::Content wrapper-->

    </div>
    <!--end:::Main-->
@endsection
@section('scripts')
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
        $( "body" ).on( "change", "#seller_time", function() {
            var id = $(this).val();
            if(id == "exact_time"){
                $('#from-seller-div').show();
                $('#to-seller-div').show();
            }else{
                $('#from-seller-div').hide();
                $('#to-seller-div').hide();
            }
        });
        function do_most_seller(){
            $.ajax({
                type: "get",
                url: "{{ route('admin.search.most-seller') }}",
                data: $("#most_seller").serialize(),
                success: function (data) {
                    $('.menu-sub').hide();
                    $('#get_most_seller').empty().append(data.html);

                },
            });
        }
        function do_lowest_seller(){
            $.ajax({
                type: "get",
                url: "{{ route('admin.search.lowest-seller') }}",
                data: $("#lowest_seller").serialize(),
                success: function (data) {
                    $('.menu-sub').hide();
                    $('#get_lowest_seller').empty().append(data.html);

                },
            });
        }
    </script>
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

