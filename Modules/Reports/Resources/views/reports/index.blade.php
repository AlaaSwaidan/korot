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
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">تقرير مجمع
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
                    <li class="breadcrumb-item text-muted">تقرير مجمع  </li>
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
            @include('reports::reports.search_form')

            <!--begin::Card-->
            @if(isset($data))
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-subscription-table-toolbar="base">
                            <form action="{{route('admin.all-reports.excel')}}" method="post" >
                                @csrf

                                <button type="submit"  class="btn btn-success disabledbutton">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                    <i class="fas fa-file-excel"></i>
                                    <!--end::Svg Icon-->
                                </button>
                                <input type="hidden" name="from_date" value="{{ isset($from_date) ? $from_date : '' }}">
                                <input type="hidden" name="to_date" value="{{ isset($to_date) ? $to_date : '' }}">

                            </form>
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Card toolbar-->
                    <h4>الاجمالي </h4>
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_subscriptions_table">
                        <!--begin::Table head-->
                        <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                            <th >اجمالي المبيعات</th>
                            <th >اجمالي المشتريات</th>
                            <th >اجمالي المصروفات</th>
                            <th >اجمالي الأرباح</th>
                            @foreach($banks as $bank)
                                <th>اجمالي رصيد  {{ $bank->name['ar'] }}</th>
                            @endforeach
                        </tr>
                        <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="text-gray-600 fw-semibold">

                        <tr>
                            <td>
                                {{ $data->where('type','sales')->sum('amount') }}
                            </td>
                            <td>
                                {{ $invoices->sum('total_after_tax') }}
                            </td>
                            <td>
                                {{ $outgoing->sum('total') }}
                            </td>
                            <td>
                                {{ $data->where('type','profits')->sum('amount') + $data->where('type','sales')->sum('profits')  }}
                            </td>
                            @foreach($banks as $bank)
                                <td>
                                    {{  $journals->where('bank_id',$bank->id)->where('type','collection')->sum('credit') -
                                      ($journals->where('bank_id',$bank->id)->where('type','purchases')->sum('debit') +
                                      $journals->where('bank_id',$bank->id)->where('type','outgoings')->sum('debit'))  }}
                                </td>
                            @endforeach

                        </tr>


                        </tbody>
                        <!--end::Table body-->
                    </table>

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
    </script>

@endsection
