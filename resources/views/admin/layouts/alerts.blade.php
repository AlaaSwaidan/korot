 @if(count($errors) > 0)
     <div id="kt_app_content" class="app-content flex-column-fluid">
         <!--begin::Content container-->
         <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Notice-->
            <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed p-6">
                <!--begin::Icon-->
                <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                <span class="svg-icon svg-icon-2tx svg-icon-danger me-4">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                            <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor" />
                            <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor" />
                        </svg>
                    </span>
                <!--end::Svg Icon-->
                <!--end::Icon-->
                <!--begin::Wrapper-->
                <div class="d-flex flex-stack flex-grow-1">
                    <!--begin::Content-->
                    <div class="fw-semibold">
                        <h4 class="text-gray-900 fw-bold"> نحن بحاجة إلى انتباهكم! </h4>
                        @foreach($errors->all() as $error)
                            <div class="fs-6 text-gray-700">
                                {{ $error }}
                            </div>
                        @endforeach
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Notice-->
         </div>
     </div>
        @endif

@if(Session::has('success'))
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
    <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed rounded-3 p-6">
        <!--begin::Wrapper-->
        <div class="d-flex flex-stack flex-grow-1">
            <!--begin::Content-->
            <div class="fw-semibold">
                <h4 class="text-gray-900 fw-bold">{{ Session::get('success') }}</h4>
            </div>
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->
    </div>
        </div>
    </div>
@endif

@if(Session::has('danger'))
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
    <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed rounded-3 p-6">
        <!--begin::Wrapper-->
        <div class="d-flex flex-stack flex-grow-1">
            <!--begin::Content-->
            <div class="fw-semibold">
                <h4 class="text-gray-900 fw-bold">{{ Session::get('danger') }}</h4>
            </div>
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->
    </div>
        </div>
    </div>
@endif
@if(Session::has('warning'))
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
    <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed rounded-3 p-6">
        <!--begin::Wrapper-->
        <div class="d-flex flex-stack flex-grow-1">
            <!--begin::Content-->
            <div class="fw-semibold">
                <h4 class="text-gray-900 fw-bold">{{ Session::get('warning') }}</h4>
            </div>
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->
    </div>
        </div>
    </div>
@endif
