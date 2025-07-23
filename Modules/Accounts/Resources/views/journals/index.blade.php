@extends('admin.layouts.master')

@section('title')
   الدفاتر اليومية
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
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">الدفاتر اليومية
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
                    <li class="breadcrumb-item text-muted">الدفاتر اليومية  </li>
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
            @include('accounts::journals.search_form')
            <!--begin::Card-->
                 @if(isset($data))
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <h4>الاجمالي </h4>
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_subscriptions_table">
                        <!--begin::Table head-->
                        <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                            <th >اجمالي المشتريات</th>
                            @foreach($banks as $bank)
                                <th> {{ $bank->name['ar'] }}</th>
                            @endforeach
                        </tr>
                        <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="text-gray-600 fw-semibold">

                       <tr>
                           <td>
                               {{ $last_data->where('type','purchases')->sum('debit') }}
                           </td>
                           @foreach($banks as $bank)
                               <td>
                                   {{ $last_data->where('bank_id',$bank->id)->where('type','purchases')->sum('debit') }}
                               </td>
                            @endforeach

                       </tr>


                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_subscriptions_table">
                        <!--begin::Table head-->
                        <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                            <th >اجمالي التحصيلات</th>
                            @foreach($banks as $bank)
                                <th> {{ $bank->name['ar'] }}</th>
                            @endforeach
                        </tr>
                        <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="text-gray-600 fw-semibold">

                       <tr>
                           <td>
                               {{ $last_data->where('type','collection')->sum('credit') }}
                           </td>
                           @foreach($banks as $bank)
                               <td>
                                   {{ $last_data->where('bank_id',$bank->id)->where('type','collection')->sum('credit') }}
                               </td>
                            @endforeach

                       </tr>


                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_subscriptions_table">
                        <!--begin::Table head-->
                        <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                            <th >اجمالي المصروفات</th>
                            @foreach($banks as $bank)
                                <th> {{ $bank->name['ar'] }}</th>
                            @endforeach
                        </tr>
                        <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="text-gray-600 fw-semibold">

                       <tr>
                           <td>
                               {{ $last_data->where('type','outgoings')->sum('debit') }}
                           </td>
                           @foreach($banks as $bank)
                               <td>
                                   {{ $last_data->where('bank_id',$bank->id)->where('type','outgoings')->sum('debit') }}
                               </td>
                            @endforeach

                       </tr>


                        </tbody>
                        <!--end::Table body-->
                    </table>

                    <!--end::Table-->

                        <?php $j=0;
                        ?>
                    @foreach($data as $key => $month)


                        <!--collapse-->
                        <!--begin::Row-->
                        <div class="row mb-12">
                            <!--begin::Col-->
                            <div class="col-md-12 pe-md-10 mb-10 mb-md-0">

                                <!--begin::Accordion-->
                                <!--begin::Section-->
                                <div class="m-0">
                                    <!--begin::Heading-->
                                    <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_job_{{$month->first()->id.$key}}">
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
                                            {{ $month->first()->bank->type == "bank" ? ' بنك :'.$month->first()->bank->name['ar'] : 'الخزنة :'.$month->first()->bank->name['ar'] }}
                                            <!--end::Title-->
                                        </h4>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Body-->
                                    <div id="kt_job_{{$month->first()->id.$key}}" class="collapse fs-6 ms-1">
                                        <!--begin::Text-->

                                        <!--start::foreach-->

                                        @foreach($month as $key1 =>$value)



                                            <!--begin::Section-->
                                            <div class="m-0">
                                                <!--begin::Body-->
                                                    <!--begin::Text-->
                                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_subscriptions_table">
                                                        <!--begin::Table head-->
                                                        <thead>
                                                        <!--begin::Table row-->
                                                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                                                            <th >#</th>
                                                            <th >رقم الفاتورة</th>
                                                            <th >اسم البنك/الخزن</th>
                                                            <th >التاريخ</th>
                                                            <th >رقم الحساب</th>
                                                            <th >دائن</th>
                                                            <th >مدين</th>
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
                                                                @if($value->type == "collection")
                                                                    <a href="{{ route('admin.journals.generate-pdf',$value->invoice_id) }}">#{{ $value->invoice_id }}</a>
                                                                @elseif($value->type == "purchases")
                                                                    <a href="{{ route('admin.purchase-orders.show',ltrim($value->invoice_id, 'PO')) }}">#{{ $value->invoice_id }}</a>
                                                                @elseif($value->type == "outgoings")
                                                                    <a href="{{ route('admin.outgoings.show',ltrim($value->invoice_id, 'E')) }}">#{{ $value->invoice_id }}</a>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <div class="badge badge-light-primary">{{ $value->bank->name['ar'] }}</div>
                                                            </td>
                                                            <td>
                                                                <div class="badge badge-light-primary">{{ $value->created_at->format('Y-m-d') }}</div>
                                                            </td>
                                                            <td>
                                                                <div class="badge badge-light-primary">{{ $value->account_number ?? '---'  }}</div>
                                                            </td>
                                                            <td>
                                                                <div class="badge badge-light-primary">{{ $value->credit  }}</div>
                                                            </td>
                                                            <td>
                                                                <div class="badge badge-light-success">{{ $value->debit }}</div>
                                                            </td>
                                                            <td>
                                                                <div class="badge badge-light-primary">{{ $value ? $value->balance : 0   }}</div>
                                                            </td>

                                                        </tr>

                                                        </tbody>
                                                        <!--end::Table body-->
                                                    </table>
                                                    <!--end::Table-->
                                                    <hr>
                                                    <!--end::Text-->

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
