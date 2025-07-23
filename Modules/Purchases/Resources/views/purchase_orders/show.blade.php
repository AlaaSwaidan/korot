@extends('admin.layouts.master')

@section('title')
    عرض تفاصيل فاتورة أمر الشراء
@endsection

@section('page_header')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">أوامر الشراء</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('admin.purchase-orders.index','type=confirm') }}" class="text-muted text-hover-primary">أوامر الشراء</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">عرض تفاصيل فاتورة أمر الشراء</li>
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
            <!-- begin::Invoice 3-->
            <div class="card">
                <!-- begin::Body-->
                <div class="card-body py-20">
                    <!-- begin::Wrapper-->
                    <div class="mw-lg-950px mx-auto w-100">
                        <!-- begin::Header-->
                        <div class="d-flex justify-content-between flex-column flex-sm-row mb-19">
                            <h4 class="fw-bolder text-gray-800 fs-2qx pe-5 pb-7">الفاتورة</h4>
                            <!--end::Logo-->
                            <div class="text-sm-end">
                                <!--begin::Logo-->
                                <a href="{{ route('admin.home') }}" class="d-block mw-150px ms-sm-auto">
                                    <img alt="Logo" src="{{ asset('admin/logo/logo.png') }}" class="w-100" />
                                </a>
                                <!--end::Logo-->
                                <!--begin::Text-->
                                <div class="text-sm-end fw-semibold fs-4 text-muted mt-7">
                                    <div>{{ settings()->bank_name['ar'] }}, {{ settings()->bank_address['ar'] }}</div>
                                    <div>{{ settings()->phone }}</div>
                                </div>
                                <!--end::Text-->
                                <!--begin::Text-->
                                <div class="text-sm-end fw-semibold fs-4 text-muted mt-7">
                                    <div> <img style="border: none;width: 100px;height: 100px;" src="{{ asset('/uploads/qr-code-images/'.$qrcode)  }}" /></div>
                                </div>
                                <!--end::Text-->

                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="pb-12">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-column gap-7 gap-md-10">
                                <!--begin::Message-->
                                <div class="fw-bold fs-2">مرحبا {{ $purchaseOrder->supplier->name }}
                                    <span class="fs-6">({{ $purchaseOrder->supplier->email }})</span>,
                                    <br />
                                    <span class="text-muted fs-5">هنا تفاصيل طلبك. نشكركم على الشراء.</span></div>
                                <!--begin::Message-->
                                <!--begin::Separator-->
                                <div class="separator"></div>
                                <!--begin::Separator-->
                                <!--begin::Order details-->
                                <div class="d-flex flex-column flex-sm-row gap-7 gap-md-10 fw-bold">
                                    <div class="flex-root d-flex flex-column">
                                        <span class="text-muted">رقم الطلب</span>
                                        <span class="fs-5">#{{ $purchaseOrder->id }}</span>
                                    </div>
                                    <div class="flex-root d-flex flex-column">
                                        <span class="text-muted">التاريخ</span>
                                        <span class="fs-5">{{ $purchaseOrder->confirm_date }}</span>
                                    </div>
                                    <div class="flex-root d-flex flex-column">
                                        <span class="text-muted">رقم الفاتورة</span>
                                        <span class="fs-5">#{{ $purchaseOrder->invoice_id }}</span>
                                    </div>
                                    <div class="flex-root d-flex flex-column">
                                        <span class="text-muted">اسم البنك</span>
                                        <span class="fs-5">#{{ $purchaseOrder->bank->name['ar'] }}</span>
                                    </div>
                                </div>
                                <!--end::Order details-->
                                <!--begin::Billing & shipping-->
                                <div class="d-flex flex-column flex-sm-row gap-7 gap-md-10 fw-bold">
                                    <div class="flex-root d-flex flex-column">
                                        <span class="text-muted">المورد</span>
                                        <span class="fs-6">{{ $purchaseOrder->supplier->name }},
																<br />{{ $purchaseOrder->supplier->phone }},
																<br />{{ $purchaseOrder->supplier->email }},
																</span>
                                    </div>
                                    <div class="flex-root d-flex flex-column">
                                        <span class="text-muted">تفاصيل الفاتورة</span>
                                        <span class="fs-6">تاريخ أمر الشراء {{ $purchaseOrder->purchase_order_date }},
																<br />تاريخ الاستلام {{ $purchaseOrder->received_date }},
																</span>
                                    </div>
                                </div>
                                <!--end::Billing & shipping-->
                                <!--begin:Order summary-->
                                <div class="d-flex justify-content-between flex-column">
                                    <!--begin::Table-->
                                    <div class="table-responsive border-bottom mb-9">
                                        <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                            <thead>
                                            <tr class="border-bottom fs-6 fw-bold text-muted">
                                                <th class="min-w-175px pb-2">اسم الباقة</th>
                                                <th class="min-w-70px text-end pb-2">الكمية</th>
                                                <th class="min-w-80px text-end pb-2">السعر</th>
                                                <th class="min-w-100px text-end pb-2">الضريبة</th>
                                                <th class="min-w-100px text-end pb-2">نسبة الخصم</th>
                                                <th class="min-w-100px text-end pb-2">الاجمالي</th>
                                            </tr>
                                            </thead>
                                            <tbody class="fw-semibold text-gray-600">
                                            <!--begin::Products-->
                                            @foreach($products as $value)
                                                <tr>
                                                    <td >
                                                    {{ $value->product_id == "digital_balance" ? "الرصيد الرقمي" : $value->package->category->company->name['ar'] .' - '. $value->package->category->name['ar'] .' - '. $value->package->name['ar'] }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ $value->quantity }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ $value->price }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ $value->tax }} %
                                                    </td>
                                                    <td class="text-end">
                                                        {{ $value->discount_amount }} %
                                                    </td>
                                                    <td class="text-end">
                                                        {{ $value->total.' '.$purchaseOrder->currency->name }}
                                                    </td>

                                                </tr>
                                            @endforeach
                                            <!--end::Products-->

                                            <!--begin::VAT-->
                                            @if($purchaseOrder->total_discount_amount > 0)
                                                <tr>
                                                    <td colspan="5" class="text-end">قيمة الخصم</td>
                                                    <td class="text-end">{{ $purchaseOrder->total_discount_amount.' '.$purchaseOrder->currency->name }}</td>
                                                </tr>
                                            @endif
                                            <!--begin::Subtotal-->
                                            <tr>
                                                <td colspan="5" class="text-end">اجمالي قبل الضريبة</td>
                                                <td class="text-end">{{ $purchaseOrder->total_before_tax.' '.$purchaseOrder->currency->name }}</td>
                                            </tr>
                                            <!--end::Subtotal-->
                                            <!--begin::VAT-->
                                            @if($purchaseOrder->products()->where('choose_tax',"with_tax")->count() > 0)
                                                <tr>
                                                    <td colspan="5" class="text-end">مبلغ الضريبة</td>
                                                    <td class="text-end">{{ $purchaseOrder->tax_amount.' '.$purchaseOrder->currency->name }}</td>
                                                </tr>
                                            @endif

                                            <!--end::VAT-->
                                            <!--begin::Grand total-->
                                            <tr>
                                                <td colspan="5" class="fs-3 text-dark fw-bold text-end">اجمالي بعد الضريبة</td>
                                                <td class="text-dark fs-3 fw-bolder text-end">{{ $purchaseOrder->total_after_tax.' '.$purchaseOrder->currency->name }}</td>
                                            </tr>
                                            <!--end::Grand total-->
                                            </tbody>
                                        </table>
                                    </div>
                                    <!--end::Table-->
                                </div>
                                <!--end:Order summary-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Body-->
                        <!-- begin::Footer-->
                        <div class="d-flex flex-stack flex-wrap mt-lg-20 pt-13">
                            <!-- begin::Actions-->
                            <div class="my-1 me-5">
                                <!-- begin::Pint-->
                                <button type="button" class="btn btn-success my-1 me-12" onclick="window.print();">طباعة الفاتورة</button>
                                <!-- end::Pint-->

                            </div>
                            <!-- end::Actions-->
                        </div>
                        <!-- end::Footer-->
                    </div>
                    <!-- end::Wrapper-->
                </div>
                <!-- end::Body-->
            </div>
            <!-- end::Invoice 1-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
@endsection
