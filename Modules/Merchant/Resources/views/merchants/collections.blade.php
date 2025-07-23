@extends('admin.layouts.master')

@section('title')
    عرض تفاصيل التاجر
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
                        <a href="{{ route('admin.merchants.index') }}" class="text-muted text-hover-primary">التجار</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">عرض تفاصيل التاجر</li>
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
            @include('merchant::merchants._profile')
            <!--begin::details View-->
            <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                <!--begin::Form-->
                <form action="{{ route('admin.merchants.profile-collections-search',$merchant->id) }}">
                    <!--begin::Card-->
                    <div class="card mb-7">
                        <!--begin::Card body-->
                        <div class="card-body">
                            <!--begin::Compact form-->
                            <div class="d-flex align-items-center">
                                <!--begin::Input group-->
                                <div class="position-relative w-md-400px me-md-2">
                                    <!--begin::Col-->
                                    <div class="col-lg-6">
                                        <label class="fs-6 form-label fw-bold text-dark">الفترة الزمنية</label>
                                        <!--begin::Select-->
                                        <select class="form-select form-select-solid" name="time" data-control="select2" data-placeholder="الفترة الزمنية" data-hide-search="true">
                                            <option value=""></option>
                                            <option value="today" {{ isset($time) && $time == "today" ? 'selected' : '' }}>اليوم</option>
                                            <option value="exact_time" {{ isset($time) && $time == "exact_time" ? 'selected' : '' }}>فترة محددة</option>
                                        </select>
                                        <!--end::Select-->
                                    </div>
                                    <!--end::Col-->
                                    <input type="hidden" name="type" value="merchants">
                                    <!--end::Col-->
                                    <!--begin::Row-->
                                    <div class="row g-8">
                                        <!--begin::Col-->
                                        <div id="from-div" style="@if(isset($startDate)) display: block; @else display: none; @endif" class="col-lg-6">
                                            <label class="fs-6 form-label fw-bold text-dark">من</label>
                                            <input type="date" class="form-control form-control form-control-solid" name="from_date" value="{{ isset($startDate) ? $startDate->format('Y-m-d') : null }}" />
                                        </div>
                                        <!--end::Col-->

                                        <!--begin::Col-->
                                        <div id="to-div" style="@if(isset($startDate)) display: block; @else display: none; @endif" class="col-lg-6">
                                            <label class="fs-6 form-label fw-bold text-dark">الى</label>
                                            <input type="date" class="form-control form-control form-control-solid" name="to_date" value="{{ isset($endDate) ? $endDate->format('Y-m-d') : null }}" />

                                        </div>
                                        <!--end::Col-->

                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Input group-->
                                <!--begin:Action-->
                                <div class="d-flex">
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
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <form action="{{route('admin.merchants.profile-collections-excel')}}" method="post" >
                        @csrf

                        <button type="submit"  class="btn btn-success disabledbutton">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                            <i class="fas fa-file-excel"></i>
                            <!--end::Svg Icon-->
                        </button>
                        <input type="hidden" name="type" value="merchants">
                        <input type="hidden" name="user_id" value="{{ $merchant->id }}">
                        <input type="hidden" name="from_date" value="{{ isset($startDate) ? $startDate : null }}">
                        <input type="hidden" name="to_date" value="{{ isset($endDate) ? $endDate : null }}">
                        <input type="hidden" name="time" value="{{ isset($time) ? $time : null }}">

                    </form>
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_subscriptions_table">
                        <!--begin::Table head-->
                        <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                            <th >#</th>
                            <th >من طرف</th>
                            <th >الرصيد</th>
                            <th >نوع التحصيل</th>
                            <th>وصل التحصيل</th>
                            <th >التاريخ</th>

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
                                    @if($value->fromAdmin->image)
                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                            <a href="{{ $value->fromAdmin->image_full_path }}">
                                                <div class="symbol-label">
                                                    <img src="{{ $value->fromAdmin->image_full_path }}" alt="{{ $value->fromAdmin->name }}" class="w-100">
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                    <!--end::Avatar-->
                                    <!--begin::User details-->
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('admin.admins.show',$value->fromAdmin->id) }}" class="text-gray-800 text-hover-primary mb-1">{{ $value->fromAdmin->name }}</a>
                                        <span>{{ $value->fromAdmin->email }}</span>
                                    </div>
                                    <!--begin::User details-->
                                </td>
                                <!--end::Customer=-->
                                <td>
                                    <div class="badge badge-light-info">  {{ $value->amount }}</div>
                                </td>
                                <td>
                                    {{ collectionType($value->collection_type) }}
                                </td>

                                <td>
                                    <a href="{{ route('admin.collections.balance-merchant-pdf', $value->id) }}" target="_blank" class="text-gray-800 text-hover-primary mb-1">وصل التحصيل</a>
                                </td>



                                <!--begin::Status=-->
                                <td>
                                    <div class="badge badge-light-danger">{{ $value->created_at->format('Y-m-d g:i A')}}</div>
                                </td>
                                <!--end::Status=-->

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
