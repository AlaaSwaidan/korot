@extends('admin.layouts.master')

@section('title')
    تفاصيل صلاحية
@endsection

@section('page_header')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">الصلاحيات</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('admin.roles.index') }}" class="text-muted text-hover-primary">الصلاحيات</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">تفاصيل صلاحية</li>
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
            <div class="card card-flush">


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">لوحه الصلاحيات</h4>

                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label class="col-form-label">الإسم</label>
                                        <span class="asterisk" style="color: red;"> * </span>
                                        <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                               name="name" placeholder="اسم الصلاحية"
                                         disabled      value="{{old('name',isset($role) ? $role->name:'')}}" required>

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                                        @endif

                                    </div>




                                </div>

                            </div> <!-- end card-body -->
                        </div> <!-- end card-->
                    </div> <!-- end col -->
                </div>


                <div class="row">

                    @php
                        $count = 0;
                    @endphp

                    @foreach($modules as $module)

                        @if(in_array($module->name , []))
                            @continue
                        @endif

                        @if($count == 7)
                            @php
                                $count = 0;
                            @endphp
                        @endif


                        <div class="col-md-4 card card-flush h-md-100">
                            <!--begin::Card-->
                            <div class="card card-flush h-md-100">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <h2>  {{ __("admin.".$module->name) }}</h2>
                                    </div>
                                    <!--end::Card title-->
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-1">


                                    <div class="d-flex flex-column text-gray-600">

                                        @foreach ($module->permissions as $permission)

                                            @can($permission->name)

                                                <div class="ribbon-content">

                                                    <div class="checkbox checkbox-primary mb-2">
                                                        <input type="checkbox" id="switch-s-1_{{ $permission->id }}" name="permissions[]"
                                                    disabled           value="{{$permission->id}}"
                                                               class="module_permissions_{{$module->id}} for_check_all"
                                                            {{isset($role) && $role->hasPermissionTo($permission->name)? 'checked':''}}
                                                        >
                                                        <label for="switch-s-1_{{ $permission->id }}">
                                                            {{ trans("admin.".explodeByUnderscore($permission->name)[0]) }} {{ trans("admin.".getExplodeByUnderscore($permission->name)) }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endcan
                                        @endforeach



                                    </div>
                                    <!--end::Permissions-->
                                </div>

                            </div>
                            <!--end::Card-->
                        </div>







                        @php
                            $count++;
                        @endphp

                    @endforeach
                </div>






            </div>
            <!--end::Card-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
@endsection

