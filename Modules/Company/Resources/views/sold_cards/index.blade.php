@extends('admin.layouts.master')

@section('title')
    البطاقات
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
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">البطاقات</h1>
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
                    <li class="breadcrumb-item text-muted">البطاقات</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
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
            @include('company::sold_cards.search_form')
            <!--begin::Card-->
            <div class="card">

                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_subscriptions_table">
                        <!--begin::Table head-->
                        <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                            <th >#</th>
                            <th >رقم العملية</th>
                            <th >رقم البطاقة</th>
                            <th >الرقم التسلسلي</th>
                            <th >تاريخ الانتهاء</th>
                            <th >التاريخ</th>
                            <th >التفاصيل</th>
                            <th >فاتورة البطاقة</th>
                            <th >استرجاع البطاقة</th>

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
                                <td>
                                   {{ getTransactionId($value->card_number,$value->serial_number) }}
                                </td>

                                <td>
                                    <div class="badge badge-light-info">  {{ '**** **** **** '.substr ($value->card_number, -4)  }}</div>
                                </td>
                                <td>
                                    <div class="badge badge-light-info">  {{ $value->serial_number }}</div>
                                </td>
                                <td>
                                    <div class="badge badge-light-info">  {{ $value->end_date }}</div>
                                </td>

                                <!--begin::Date=-->
                                <td>{{ $value->created_at->format('Y-m-d g:i A') }}</td>
                                <!--end::Date=-->
                                <td>
                                    <a href="#" class="btn btn-primary er fs-6 px-8 py-4" data-bs-toggle="modal" data-bs-target="#kt_modal_{{ $value->id  }}">عرض التفاصيل</a>

                                </td>
                                <td>
                                    <a href="{{ route('admin.cards.sold-cards-pdf', $value->id) }}" target="_blank" class="text-gray-800 text-hover-primary mb-1">الفاتورة</a>
                                </td>
                                <td>
                                    <a  data="{{ $value->id }}" data_name="{{$value->card_number }}"   class="menu-link text-danger px-3 delete_row">استرجاع البطاقة</a>

                                </td>

                            </tr>
                            <!--begin::Modal - View cards-->
                            <div class="modal fade" id="kt_modal_{{ $value->id  }}" tabindex="-1" aria-hidden="true">
                                <!--begin::Modal dialog-->
                                <div class="modal-dialog mw-650px">
                                    <!--begin::Modal content-->
                                    <div class="modal-content">
                                        <!--begin::Modal header-->
                                        <div class="modal-header pb-0 border-0 justify-content-end">
                                            <!--begin::Close-->
                                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                                <span class="svg-icon svg-icon-1">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                                            </svg>
                                                        </span>
                                                <!--end::Svg Icon-->
                                            </div>
                                            <!--end::Close-->
                                        </div>
                                        <!--begin::Modal header-->
                                        <!--begin::Modal body-->
                                        <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                                            <!--begin::Heading-->
                                            <div class="text-center mb-13">
                                                <!--begin::Title-->
                                                <h1 class="mb-3">التفاصيل</h1>
                                                <!--end::Title-->
                                            </div>
                                            <!--end::Heading-->
                                            <!--begin::Users-->
                                            <div class="mb-15">
                                                <!--begin::List-->
                                                <!--begin::Card body-->
                                                <div class="card-body p-9">
                                                    <!--begin::Row-->
                                                    <div class="row mb-7">
                                                        <!--begin::Label-->
                                                        <label class="col-lg-4 fw-semibold text-muted">رقم البطاقة</label>
                                                        <!--end::Label-->
                                                        <!--begin::Col-->
                                                        <div class="col-lg-8">
                                                            <span class="fw-bold fs-6 text-gray-800">{{ $value->card_number }}</span>
                                                        </div>
                                                        <!--end::Col-->
                                                    </div>
                                                    <!--end::Row-->
                                                    <!--begin::Input group-->
                                                    <div class="row mb-7">
                                                        <!--begin::Label-->
                                                        <label class="col-lg-4 fw-semibold text-muted">الرقم التسلسلي</label>
                                                        <!--end::Label-->
                                                        <!--begin::Col-->
                                                        <div class="col-lg-8 fv-row">
                                                            <span class="fw-semibold text-gray-800 fs-6">{{ $value->serial_number }}</span>
                                                        </div>
                                                        <!--end::Col-->
                                                    </div>
                                                    <!--end::Input group-->
                                                    <!--begin::Input group-->
                                                    <div class="row mb-7">
                                                        <!--begin::Label-->
                                                        <label class="col-lg-4 fw-semibold text-muted">تاريخ الانتهاء</label>
                                                        <!--end::Label-->
                                                        <!--begin::Col-->
                                                        <div class="col-lg-8 fv-row">
                                                            <span class="fw-semibold text-gray-800 fs-6">{{ $value->end_date }}</span>
                                                        </div>
                                                        <!--end::Col-->
                                                    </div>
                                                    <!--end::Input group-->


                                                    <!--begin::Input group-->
                                                    <div class="row mb-10">
                                                        <!--begin::Label-->
                                                        <label class="col-lg-4 fw-semibold text-muted">التاجر</label>
                                                        <!--begin::Label-->

                                                        <!--begin::Col-->
                                                        <div class="col-lg-8 fv-row">
                                                            <span class="fw-semibold text-gray-800 fs-6">{{ getOrder($value) ?  getOrder($value)->merchant->name : '--' }}</span>
                                                        </div>
                                                        <!--end::Col-->

                                                    </div>
                                                    <!--end::Input group-->
                                                    <!--begin::Input group-->
                                                    <div class="row mb-10">
                                                        <!--begin::Label-->
                                                        <label class="col-lg-4 fw-semibold text-muted">تاريخ البيع</label>
                                                        <!--begin::Label-->
                                                        <!--begin::Label-->
                                                        <div class="col-lg-8">
                                                            <span class="fw-semibold fs-6 text-gray-800">{{ getOrder($value) ?  getOrder($value)->created_at->format('Y-m-d g:i A') : '--'  }}</span>
                                                        </div>
                                                        <!--begin::Label-->
                                                    </div>
                                                    <!--end::Input group-->

                                                </div>
                                                <!--end::Card body-->
                                                <!--end::List-->
                                            </div>
                                            <!--end::Users-->
                                        </div>
                                        <!--end::Modal body-->
                                    </div>
                                    <!--end::Modal content-->
                                </div>
                                <!--end::Modal dialog-->
                            </div>
                            <!--end::Modal - View cards-->
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
    <script src="{{ URL::asset('admin/assets/js/custom/utilities/modals/create-project/settings.js') }}"></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->


    <script>
        var CSRF_TOKEN = $('meta[name="X-CSRF-TOKEN"]').attr('content');
        $(document).ready(function() {

            var CSRF_TOKEN = $('meta[name="X-CSRF-TOKEN"]').attr('content');

            $('body').on('click', '.delete_row', function() {

                var id = $(this).attr('data');
                var name = $(this).attr('data_name');

                // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                Swal.fire({
                    text: "هل أنت متأكد من استرجاع رقم البطاقة  " + name + " ؟ ",
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
                            url: "{{ url('/') }}" + "/admin/sold-cards/recover" ,
                            type: "POST",
                            data: {_token: CSRF_TOKEN, 'id': id},
                        })
                            .done(function(reseived_data) {
                                var parsed_data = $.parseJSON(reseived_data);

                                if(parsed_data.code === '1'){
                                    Swal.fire({
                                        text: "تم استرجاع رقم البطاقة " + name + " بنجاح .",
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
                                        confirmButtonText: "تأكيد !",
                                        customClass: {
                                            confirmButton: "btn fw-bold btn-primary",
                                        }
                                    });
                                }
                            });

                    } else if (result.dismiss === 'cancel') {
                        Swal.fire({
                            text: name + " لم يتم استرجاع البطاقة. ",
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
