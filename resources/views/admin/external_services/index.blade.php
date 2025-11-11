@extends('admin.layouts.master')

@section('title', 'فواتير الخدمات الخارجية')

@section('page_header')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading text-dark fw-bold fs-3 my-0">فواتير الخدمات الخارجية</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('admin.home') }}" class="text-muted text-hover-primary">الرئيسية</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">فواتير الخدمات</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="card">
                <!-- 🔍 Filter Form -->
                <div class="card-header border-0 pt-6">
                    <form method="GET" class="d-flex align-items-center gap-3">
                        <div>
                            <label for="date" class="form-label fw-semibold mb-0">الشهر</label>
                            <input type="month" id="date" name="date" class="form-control form-control-solid"
                                   value="{{ $date }}" max="{{ now()->format('Y-m') }}">
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                بحث
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-body pt-0">
                    <table class="table align-middle table-row-dashed fs-6 gy-5">
                        <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th>#</th>
                            <th>رقم الفاتورة</th>
                            <th>رقم التاجر</th>
                            <th>اسم التاجر</th>
                            <th>الرقم الضريبي</th>
                            <th>الرقم التجاري</th>
                            <th>المدينة</th>
                            <th>إجمالي الفاتورة</th>
                            <th>تاريخ الفاتورة</th>
                            <th>العناصر</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-semibold" id="invoice-list">
                       @include('admin.external_services.invoice_rows_ajax')
                        </tbody>
                    </table>
                </div>
                {!! $invoices->render() !!}
            </div>
        </div>
    </div>
@endsection

