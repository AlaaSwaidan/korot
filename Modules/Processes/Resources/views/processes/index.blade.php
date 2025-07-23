@extends('admin.layouts.master')

@section('title')
   العمليات  {{ $name }}
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
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">العمليات
                    {{ $name }}</h1>
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
                    <li class="breadcrumb-item text-muted">العمليات  {{ $name }}</li>
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
            @include('processes::processes.search_form')
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

                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-subscription-table-toolbar="base">
                            <form action="{{route('admin.processes.excel')}}" method="post" >
                                @csrf

                            <button type="submit"  class="btn btn-success disabledbutton">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                <i class="fas fa-file-excel"></i>
                                <!--end::Svg Icon-->
                            </button>
                                <input type="hidden" name="user_name" value="{{ isset($user_name) ? $user_name :  '' }}">
                                <input type="hidden" name="process_type" value="{{ isset($process_type) ? $process_type : '' }}">
                                <input type="hidden" name="time" value="{{ isset($time) ? $time : '' }}">
                                <input type="hidden" name="from_date" value="{{ isset($from_date) ? $from_date : '' }}">
                                <input type="hidden" name="to_date" value="{{ isset($to_date) ? $to_date : '' }}">
                                <input type="hidden" name="type" value="{{ $type }}">

                            </form>
                        </div>
                        <!--end::Toolbar-->
                    </div>
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

                            <th >#</th>
                            <th >الاسم</th>
                            <th >النوع</th>
                            <th >المبلغ</th>
                            <th >التحويلات</th>
                            <th >التحصيلات</th>
                            <th >المديونية</th>
                            <th >التعويضات</th>
                            <th >الربح</th>
                            <th >مجموع الأرباح</th>
                            <th >الرصيد</th>
                            <th>التاريخ</th>
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

                            <td> {{ $i }} </td>

                            <!--begin::Customer=-->
                            <td class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                @if(getUserModel(getClassModel($type),$value->userable_id)->image)
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="{{ getUserModel(getClassModel($type),$value->userable_id)->image_full_path }}">
                                        <div class="symbol-label">
                                            <img src="{{ getUserModel(getClassModel($type),$value->userable_id)->image_full_path }}" alt="{{ getUserModel(getClassModel($type),$value->userable_id)->name }}" class="w-100">
                                        </div>
                                    </a>
                                </div>
                                @endif
                                <!--end::Avatar-->
                                <!--begin::User details-->
                                <div class="d-flex flex-column">
                                    <a href="{{ route('admin.'.$type.'.show',getUserModel(getClassModel($type),$value->userable_id)->id) }}" class="text-gray-800 text-hover-primary mb-1">{{ getUserModel(getClassModel($type),$value->userable_id)->name }}</a>
                                    <span>{{ getUserModel(getClassModel($type),$value->userable_id)->email }}</span>
                                </div>
                                <!--begin::User details-->
                            </td>
                            <!--end::Customer=-->
                            <td>
                                {{ getProcessType($value->type) }}
                            </td>
                            <td>
                                <div class="badge badge-light-info">  {{ $value->amount }}</div>
                            </td>

                            <td>
                                <div class="badge badge-light-success">{{ $value->type == "transfer"?  ($value->transfers_total ?? 0) : '' }}</div>
                            </td>
                            <td>
                                <div class="badge badge-light-warning">{{ $value->type == "collection" ? ($value->collection_total ?? 0) : '' }}</div>
                            </td>

                            <td>
                                <div class="badge badge-light-danger">{{ $value->type == "indebtedness" || $value->type == "payment" ? ($value->indebtedness ?? 0) : ''}}</div>
                            </td>

                            <td>
                                <div class="badge badge-light-dark">{{$value->type == "repayment" ?  ($value->repayment_total ?? 0) : '' }}</div>
                            </td>

                            <td>
                                <div class="badge badge-light-primary">{{ $value->type == "profits" || $value->type == "sales"  ? $value->profits : ''}}</div>
                            </td>
                            <td>
                                <div class="badge badge-light-primary">{{ $value->type == "profits" || $value->type == "sales"  ? $value->profits_total : ''}}</div>
                            </td>

                            <td>
                                <div class="badge badge-light-primary">{{ $value->balance_total}}</div>
                            </td>
                           <td>
                               {{ $value->created_at->format('Y-m-d') }}
                           </td>
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
