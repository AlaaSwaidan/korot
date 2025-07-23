@extends('admin.layouts.master')
@section('title')
    عرض تفاصيل المدير
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
                        <a href="{{ route('admin.admins.index') }}" class="text-muted text-hover-primary">التجار</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">عرض تفاصيل المدير</li>
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
            @include('admin::admins._profile')
            <!--begin::details View-->
            <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">

                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    @include('admin::admins.search_form')
                    <!--begin::Card toolbar-->
{{--                    <div class="card-toolbar">--}}
{{--                        <!--begin::Toolbar-->--}}
{{--                        <div class="d-flex justify-content-end" data-kt-subscription-table-toolbar="base">--}}
{{--                            <form action="{{route('admin.processes.excel')}}" method="post" >--}}
{{--                                @csrf--}}

{{--                                <button type="submit"  class="btn btn-success disabledbutton">--}}
{{--                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->--}}
{{--                                    <i class="fas fa-file-excel"></i>--}}
{{--                                    <!--end::Svg Icon-->--}}
{{--                                </button>--}}
{{--                                <input type="hidden" name="type" value="merchants">--}}

{{--                            </form>--}}
{{--                        </div>--}}
{{--                        <!--end::Toolbar-->--}}
{{--                    </div>--}}
                    <!--end::Card toolbar-->
                </div>

                <!--end::Card header-->
                <!--begin::Card body-->

                <div class="card-body pt-0">
                    <!--collapse-->
                    <h4>رصيد  {{ $today }} </h4>
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_subscriptions_table">
                        <!--begin::Table head-->
                        <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                            <th >#</th>
                            <th >الرصيد الافتتاحي</th>
                            <th >اجمالي الحركات</th>
                            <th >اجمالي المبيعات</th>
                            <th >اجمالي البطاقات</th>
                            <th >اجمالي الأرباح</th>
                            <th >تحويل الأرباح لرصيد</th>
                            <th >اجمالي التحويلات</th>
                            <th >اجمالي التحصيلات</th>
                            <th >اجمالي التعويضات</th>
                            <th >شحن رصيد</th>
                            <th >الرصيد الختامي</th>
                        </tr>
                        <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="text-gray-600 fw-semibold">

                        <tr>

                            <td> 1 </td>
                            <td>
                                <div class="badge badge-light-success">{{$first_data ? $first_data->balance_total: 0}}</div>
                            </td>
                            <td>
                                {{ $last_data->count() }}
                            </td>
                            <td>
                                <div class="badge badge-light-primary">{{ $last_data->where('type','sales')->sum('amount') }}</div>
                            </td>
                            <td>
                                <div class="badge badge-light-primary">{{ $last_data->where('type','sales')->count() }}</div>
                            </td>
                            <td>
                                <div class="badge badge-light-primary">{{ $last_data->where('type','sales')->sum('profits')   }}</div>
                            </td>
                            <td>
                                <div class="badge badge-light-primary">{{ $last_data->where('type','profits')->sum('amount')  }}</div>
                            </td>
                            <td>
                                <div class="badge badge-light-success">{{ $last_data->where('type','transfer')->sum('amount') }}</div>
                            </td>
                            <td>
                                <div class="badge badge-light-warning">{{ $last_data->where('type','collection')->sum('amount') }}</div>
                            </td>

                            {{--                                <td>--}}
                            {{--                                    <div class="badge badge-light-danger">{{ $last_data->where('type','indebtedness')->sum('amount') - $last_data->where('type','payment')->sum('amount') }}</div>--}}
                            {{--                                </td>--}}

                            <td>
                                <div class="badge badge-light-dark">{{$last_data->where('type','repayment')->sum('amount') }}</div>
                            </td>

                            <td>
                                <div class="badge badge-light-primary">{{ $last_data->where('type','recharge')->sum('amount')  }}</div>
                            </td>

                            <td>
                                <div class="badge badge-light-primary">{{ $last_data->first() ? $last_data->first()->balance_total : 0   }}</div>
                            </td>

                        </tr>


                        </tbody>
                        <!--end::Table body-->
                    </table>

                    <!--end::Table-->
                    <hr>
                    <?php $j=0;
                    ?>
                    @foreach($data as $key => $month)
                            <?php
                            $k=0;
                            $total_transactions =0;
                            ?>
                            <!--collapse-->
                        <!--begin::Row-->
                        <div class="row mb-12">
                            <!--begin::Col-->
                            <div class="col-md-12 pe-md-10 mb-10 mb-md-0">

                                <!--begin::Accordion-->
                                <!--begin::Section-->
                                <div class="m-0">
                                    <!--begin::Heading-->
                                    <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_job_{{$month->first()[$j]->id.$key}}">
                                        <!--begin::Icon-->
                                        <div class="btn btn-sm btn-icon mw-20px btn-active-color-primary me-5">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen036.svg-->
                                            <span class="svg-icon toggle-on svg-icon-primary svg-icon-1">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
                                                    <rect x="6.0104" y="10.9247" width="12" height="2" rx="1" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
                                            <span class="svg-icon toggle-off svg-icon-1">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
                                                    <rect x="10.8891" y="17.8033" width="12" height="2" rx="1" transform="rotate(-90 10.8891 17.8033)" fill="currentColor" />
                                                    <rect x="6.01041" y="10.9247" width="12" height="2" rx="1" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </div>
                                        <!--end::Icon-->
                                        <!--begin::Title-->
                                        <h4 class="text-gray-700 fw-bold cursor-pointer mb-0">
                                            <!--begin::Title-->
                                            اقفال شهر  {{ getMonth($key) }}
                                            <!--end::Title-->
                                        </h4>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Body-->
                                    <div id="kt_job_{{$month->first()[$j]->id.$key}}" class="collapse fs-6 ms-1">
                                        <!--begin::Text-->
                                        <!--begin::Table-->
                                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_subscriptions_table">
                                            <!--begin::Table head-->
                                            <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                                                <th >#</th>
                                                <th >الرصيد الافتتاحي</th>
                                                <th >اجمالي الحركات</th>
                                                <th >اجمالي المبيعات</th>
                                                <th >اجمالي البطاقات</th>
                                                <th >اجمالي الأرباح</th>
                                                <th >تحويل الأرباح لرصيد</th>
                                                <th >اجمالي التحويلات</th>
                                                <th >اجمالي التحصيلات</th>
                                                <th >اجمالي التعويضات</th>
                                                <th >شحن رصيد</th>
                                                <th >الرصيد الختامي</th>
                                            </tr>
                                            <!--end::Table row-->
                                            </thead>
                                            <!--end::Table head-->
                                            <!--begin::Table body-->
                                            <tbody class="text-gray-600 fw-semibold">

                                            <tr>

                                                <td> 1 </td>
                                                <td>
                                                    <div class="badge badge-light-success">{{$last_data->where('created_at','<',\Carbon\Carbon::parse($month->first()[$j]->created_at)->startOfMonth()->format('Y-m-d'))->first() ? $last_data->where('created_at','<',\Carbon\Carbon::parse($month->first()[$j]->created_at)->startOfMonth()->format('Y-m-d'))->first()->balance_total: 0}}</div>
                                                </td>
                                                <td>
                                                    <span class="month-display-class{{$key}}"></span>

                                                </td>
                                                <td>
                                                    <div class="badge badge-light-primary">{{ $month->where('type','sales')->sum('amount') }}</div>
                                                </td>
                                                <td>
                                                    <div class="badge badge-light-primary">{{ $month->where('type','sales')->count() }}</div>
                                                </td>
                                                <td>
                                                    <div class="badge badge-light-primary">{{ $month->where('type','sales')->sum('profits')   }}</div>
                                                </td>
                                                <td>
                                                    <div class="badge badge-light-primary">{{ $month->where('type','profits')->sum('amount')  }}</div>
                                                </td>
                                                <td>
                                                    <div class="badge badge-light-success">{{ $month->where('type','transfer')->sum('amount') }}</div>
                                                </td>
                                                <td>
                                                    <div class="badge badge-light-warning">{{ $month->where('type','collection')->sum('amount') }}</div>
                                                </td>

                                                {{--                                <td>--}}
                                                {{--                                    <div class="badge badge-light-danger">{{ $last_data->where('type','indebtedness')->sum('amount') - $last_data->where('type','payment')->sum('amount') }}</div>--}}
                                                {{--                                </td>--}}

                                                <td>
                                                    <div class="badge badge-light-dark">{{$month->where('type','repayment')->sum('amount') }}</div>
                                                </td>

                                                <td>
                                                    <div class="badge badge-light-primary">{{ $month->where('type','recharge')->sum('amount')  }}</div>
                                                </td>

                                                <td>

                                                    <div class="badge badge-light-primary">
                                                        {{ $month->first() ? $month->first()[$j]->balance_total : 0   }}
                                                    </div>
                                                </td>

                                            </tr>


                                            </tbody>
                                            <!--end::Table body-->
                                        </table>
                                        <!--end::Table-->
                                        <!--start::foreach-->

                                        @foreach($month as $key1 =>$value)
                                                <?php
                                                $total_transactions += $value->count();

                                                ?>
                                            <input type="hidden" name="transaction_total" value="{{ $total_transactions }}" class="get-transaction">


                                            <!--begin::Section-->
                                            <div class="m-0">
                                                <!--begin::Heading-->
                                                <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_job_{{$value->first()->id}}">
                                                    <!--begin::Icon-->
                                                    <div class="btn btn-sm btn-icon mw-20px btn-active-color-primary me-5">
                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen036.svg-->
                                                        <span class="svg-icon toggle-on svg-icon-primary svg-icon-1">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
                                                    <rect x="6.0104" y="10.9247" width="12" height="2" rx="1" fill="currentColor" />
                                                </svg>
                                            </span>
                                                        <!--end::Svg Icon-->
                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
                                                        <span class="svg-icon toggle-off svg-icon-1">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor" />
                                                    <rect x="10.8891" y="17.8033" width="12" height="2" rx="1" transform="rotate(-90 10.8891 17.8033)" fill="currentColor" />
                                                    <rect x="6.01041" y="10.9247" width="12" height="2" rx="1" fill="currentColor" />
                                                </svg>
                                            </span>
                                                        <!--end::Svg Icon-->
                                                    </div>
                                                    <!--end::Icon-->
                                                    <!--begin::Title-->
                                                    <h4 class="text-gray-700 fw-bold cursor-pointer mb-0">
                                                        اقفال يوم  {{ $key1 }}
                                                    </h4>
                                                    <!--end::Title-->
                                                </div>
                                                <!--end::Heading-->
                                                <!--begin::Body-->
                                                <div id="kt_job_{{$value->first()->id}}" class="collapse fs-6 ms-1">
                                                    <!--begin::Text-->
                                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_subscriptions_table">
                                                        <!--begin::Table head-->
                                                        <thead>
                                                        <!--begin::Table row-->
                                                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                                                            <th >#</th>
                                                            <th >الرصيد الافتتاحي</th>
                                                            <th >اجمالي الحركات</th>
                                                            <th >اجمالي المبيعات</th>
                                                            <th >اجمالي البطاقات</th>
                                                            <th >اجمالي الأرباح</th>
                                                            <th >تحويل الأرباح لرصيد</th>
                                                            <th >اجمالي التحويلات</th>
                                                            <th >اجمالي التحصيلات</th>
                                                            <th >اجمالي التعويضات</th>
                                                            <th >شحن رصيد</th>
                                                            <th >الرصيد الختامي</th>
                                                        </tr>
                                                        <!--end::Table row-->
                                                        </thead>
                                                        <!--end::Table head-->
                                                        <!--begin::Table body-->
                                                        <tbody class="text-gray-600 fw-semibold">

                                                        <tr>

                                                            <td> 1 </td>
                                                            <td>
                                                                <div class="badge badge-light-success">{{ getDayBefore($admin,$startDate,$endDate,$value) }}</div>
                                                            </td>
                                                            <td>
                                                                {{ $value->count() }}


                                                            </td>
                                                            <td>
                                                                <div class="badge badge-light-primary">{{ $value->where('type','sales')->sum('amount') }}</div>
                                                            </td>
                                                            <td>
                                                                <div class="badge badge-light-primary">{{ $value->where('type','sales')->count() }}</div>
                                                            </td>
                                                            <td>
                                                                <div class="badge badge-light-primary">{{ $value->where('type','sales')->sum('profits')   }}</div>
                                                            </td>
                                                            <td>
                                                                <div class="badge badge-light-primary">{{ $value->where('type','profits')->sum('amount')  }}</div>
                                                            </td>
                                                            <td>
                                                                <div class="badge badge-light-success">{{ $value->where('type','transfer')->sum('amount') }}</div>
                                                            </td>
                                                            <td>
                                                                <div class="badge badge-light-warning">{{ $value->where('type','collection')->sum('amount') }}</div>
                                                            </td>

                                                            {{--                                <td>--}}
                                                            {{--                                    <div class="badge badge-light-danger">{{ $last_data->where('type','indebtedness')->sum('amount') - $last_data->where('type','payment')->sum('amount') }}</div>--}}
                                                            {{--                                </td>--}}

                                                            <td>
                                                                <div class="badge badge-light-dark">{{$value->where('type','repayment')->sum('amount') }}</div>
                                                            </td>

                                                            <td>
                                                                <div class="badge badge-light-primary">{{ $value->where('type','recharge')->sum('amount')  }}</div>
                                                            </td>

                                                            <td>

                                                                <div class="badge badge-light-primary">
                                                                    {{ $value->first() ? $value->first()->balance_total : 0   }}
                                                                </div>
                                                            </td>

                                                        </tr>


                                                        </tbody>
                                                        <!--end::Table body-->
                                                    </table>

                                                    <!--end::Table-->
                                                    <hr>
                                                    @if($loop->last)
                                                        <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>

                                                            <?php
                                                            echo "
                                            <script type=\"text/javascript\">
                                            $('.month-display-class$key').text(\" $total_transactions \");
                                            </script>
                                        ";
                                                            ?>
                                                    @endif
                                                    <!--end::Text-->
                                                </div>
                                                <!--end::Content-->
                                                <!--begin::Separator-->
                                                <div class="separator separator-dashed"></div>
                                                <!--end::Separator-->
                                            </div>
                                            <!--end::Section-->


                                        @endforeach
                                        <!--end::foreach-->
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Content-->
                                    <!--begin::Separator-->
                                    <div class="separator separator-dashed"></div>
                                    <!--end::Separator-->
                                </div>
                                <!--end::Section-->

                                <!--end::Accordion-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->

                            <?php $j++ ?>
                    @endforeach

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
