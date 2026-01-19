<!--begin::Sidebar-->
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Logo-->
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <!--begin::Logo image-->
        <a href="{{ route('admin.home') }}">
            <img alt="Logo" src="{{ asset('admin/logo/logo.png') }}" class=" app-sidebar-logo-default" style="height: 195px;" />
            <img alt="Logo" src="{{ asset('admin/logo/logo.png') }}" class=" app-sidebar-logo-minimize" style="height: 40px;"/>
        </a>
        <!--end::Logo image-->
        <!--begin::Sidebar toggle-->
        <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
            <span class="svg-icon svg-icon-2 rotate-180">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="currentColor" />
                    <path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="currentColor" />
                </svg>
            </span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Sidebar toggle-->
    </div>
    <!--end::Logo-->
    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <!--begin::Menu wrapper-->
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
            <!--begin::Menu-->
            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="2" y="2" width="9" height="9" rx="2" fill="currentColor" />
                                    <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="currentColor" />
                                    <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="currentColor" />
                                    <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">لوحة التحكم</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ strpos(URL::current(), 'home') != false ? 'active' : '' }}" href="{{ route('admin.home') }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                <span class="menu-title">الرئيسية</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->


                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->

                <!--begin:Menu item-->
                @can('viewPermission_side_menu')
                <div class="menu-item pt-5">
                    <!--begin:Menu content-->
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-7">إدارة المستخدمين</span>
                    </div>
                    <!--end:Menu content-->
                </div>
                <!--end:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ (Route::currentRouteName() == 'admin.super-admins.index'
                         || Route::currentRouteName() == 'admin.admins.index' ) ? 'here show' : '' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
                         <i class="fonticon-user-2"></i>

                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">الإشراف والصلاحيات </span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion ">
                        <!--begin:Menu item-->
                        @can('view_roles')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ Route::currentRouteName() == 'admin.roles.index' ? 'active' : '' }}" href="{{ route('admin.roles.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">الصلاحيات</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan





                       @can('view_super_admins')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ Route::currentRouteName() == 'admin.super-admins.index' ? 'active' : '' }}" href="{{ route('admin.super-admins.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">مدير النظام</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        @endcan
                        <!--begin:Menu item-->
                        @can('view_admins')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ Route::currentRouteName() == 'admin.admins.index' ? 'active' : '' }}" href="{{ route('admin.admins.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                <span class="menu-title">المدراء</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                @endcan
                <!--end:Menu item-->
                <!--begin:Menu item-->
                @can('viewUsers_side_menu')
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ (strpos(URL::current(), 'distributors') != false
                          || strpos(URL::current(), 'merchants')  != false)  ? 'here show' : '' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
                         <i class="fonticon-user"></i>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">المستخدمين </span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion ">
                        @can('waitingView_merchants')
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link  {{  (strpos(URL::current(), 'not-approved') ) != false ? 'active' : '' }}" href="{{ route('admin.merchants.not-approved') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">تجار في انتظار الموافقة</span>
                                @if(NotApprovedMerchants() > 0)
                                <span class="badge badge-light-danger">{{ NotApprovedMerchants() }}</span>
                                @endif
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        @can('view_merchants')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link  {{ (strpos(URL::current(), 'merchants') ) != false  ? 'active' : '' }}" href="{{ route('admin.merchants.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">التجار</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                         @can('view_distributors')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'distributors') ) != false  ? 'active' : '' }}" href="{{ route('admin.distributors.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                <span class="menu-title">الموزعين</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'search-geadia-machine') ) != false  ? 'active' : '' }}" href="{{ route('admin.search-geadia-machine.search-machine') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                <span class="menu-title">بحث عن الماكينة</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                            <!--begin:Menu item-->
                            @can('view_admins')
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ Route::currentRouteName() == 'admin.admins.index' ? 'active' : '' }}" href="{{ route('admin.admins.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                        <span class="menu-title">المدراء</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endcan
                            <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                @endcan
                <!--end:Menu item-->

                <!--begin:Menu item-->
                @can('viewStores_side_menu')
                <!--begin:Menu item-->
                <div class="menu-item pt-5">
                    <!--begin:Menu content-->
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-7">إدارة المخزون</span>
                    </div>
                    <!--end:Menu content-->
                </div>
                <!--end:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ (strpos(URL::current(), 'stores') != false || strpos(URL::current(), 'sold-cards') != false  ) ? 'here show' : '' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
                            <i class="fonticon-app-store"></i>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">إدارة المخزون </span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion ">
                        <!--begin:Menu item-->
                        @can('view_stores')
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ (strpos(URL::current(), 'departments') ) != false  ? 'active' : '' }}" href="{{ route('admin.departments.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                    <span class="menu-title">الكاتيجوري</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                        @endcan
                        <!--begin:Menu item-->
                        @can('view_stores')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'stores') ) != false  ? 'active' : '' }}" href="{{ route('admin.stores.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">الشركات</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        @can('sold_cards')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'sold-cards') ) != false  ? 'active' : '' }}" href="{{ route('admin.sold-cards.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                <span class="menu-title">البطاقات المباعة</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'imported-cards') ) != false  ? 'active' : '' }}" href="{{ route('admin.imported-cards.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                <span class="menu-title">تقارير البطاقات المدخله</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--begin:Menu item-->
                        <!--end:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'saled-cards') ) != false  ? 'active' : '' }}" href="{{ route('admin.saled-cards.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                <span class="menu-title">تقارير البطاقات المباعة</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--begin:Menu item-->
                        <!--end:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'duplicated-cards') ) != false  ? 'active' : '' }}" href="{{ route('admin.duplicated-cards.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                <span class="menu-title">تقارير البطاقات المدخلة المكررة</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--begin:Menu item-->
                        <!--end:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'reports-cards') ) != false  ? 'active' : '' }}" href="{{ route('admin.reports-cards.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                <span class="menu-title">تقارير البطاقات </span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--begin:Menu item-->
                        <!--end:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'reports-sales-cards') ) != false  ? 'active' : '' }}" href="{{ route('admin.reports-sales-cards.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                <span class="menu-title">تقارير مبيعات البطاقات </span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--begin:Menu item-->
                        @can('mostSeller_cards')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'most-seller-cards') ) != false  ? 'active' : '' }}" href="{{ route('admin.most-seller-cards.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                <span class="menu-title">أكثر البطاقات مبيعا</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        @can('lessSeller_cards')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'lowest-seller-cards') ) != false  ? 'active' : '' }}" href="{{ route('admin.lowest-seller-cards.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                <span class="menu-title">أقل البطاقات مبيعا</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                @endcan
                <!--end:Menu item-->
                <!--begin:Menu item-->
                @can('viewReports_side_menu')
                <div class="menu-item pt-5">
                    <!--begin:Menu content-->
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-7">التقارير</span>
                    </div>
                    <!--end:Menu content-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ (strpos(URL::current(), 'all-reports') != false )}}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
                            <i class="fonticon-layers"></i>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">التقارير </span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion ">

                        <!--begin:Menu item-->
                        @can('view_all_reports')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'all-reports') ) != false  ? 'active' : '' }}" href="{{ route('admin.all-reports.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">تقرير مجمع</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->

                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--begin:Menu item-->

                @endcan
                <!--end:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ (strpos(URL::current(), 'external_services.index') != false )}}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
                            <i class="fonticon-layers"></i>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">الفواتير </span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion ">

                        <!--begin:Menu item-->

                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ (strpos(URL::current(), 'external_services.index') ) != false  ? 'active' : '' }}" href="{{ route('admin.external_services.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                    <span class="menu-title">الفواتير المجمعة</span>
                                </a>
                                <!--end:Menu link-->
                            </div>

                        <!--end:Menu item-->

                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--begin:Menu item-->
                @can('viewTransfers_side_menu')
                <!--begin:Menu item-->
                <div class="menu-item pt-5">
                    <!--begin:Menu content-->
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-7">إدارة التشغيل</span>
                    </div>
                    <!--end:Menu content-->
                </div>
                <!--end:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ strpos(URL::current(), 'transfers') != false   ? 'here show' : ''}}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
                           <i class="fonticon-cash-payment fs-x"></i>

                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">التحويلات </span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion ">
                        @can('view_merchant_transfers')
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'merchants') ) != false  ? 'active' : '' }}" href="{{ route('admin.transfers.index','type=merchants') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">التجار</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        @can('view_distributors_transfers')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'distributors') ) != false  ? 'active' : '' }}" href="{{ route('admin.transfers.index','type=distributors') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                <span class="menu-title">الموزعين</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        @can('view_admins_transfers')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'admins') ) != false  ? 'active' : '' }}" href="{{ route('admin.transfers.index','type=admins') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                <span class="menu-title">المدراء</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                @endcan
                <!--end:Menu item-->
                <!--begin:Menu item-->
                @can('viewCollections_side_menu')
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ strpos(URL::current(), 'collections') != false   ? 'here show' : ''}}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
                        <i class="fonticon-bank"></i>


                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">التحصيلات </span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion ">

                        <!--begin:Menu item-->
                        @can('view_merchant_collections')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'merchants') ) != false  ? 'active' : '' }}" href="{{ route('admin.collections.index','type=merchants') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">التجار</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        @can('view_distributors_collections')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'distributors') ) != false  ? 'active' : '' }}" href="{{ route('admin.collections.index','type=distributors') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                <span class="menu-title">الموزعين</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        @can('view_admins_collections')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'admins') ) != false  ? 'active' : '' }}" href="{{ route('admin.collections.index','type=admins') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                <span class="menu-title">المدراء</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                @endcan
                <!--end:Menu item-->

                <!--begin:Menu item-->
                @can('viewRepayments_side_menu')
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ strpos(URL::current(), 'indebtedness') != false   ? 'here show' : ''}}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
                             <i class="fonticon-card"></i>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">التعويضات والمديونيات </span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion ">

                        <!--begin:Menu item-->
                        @can('view_merchant_repayment')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'merchants') ) != false  ? 'active' : '' }}" href="{{ route('admin.indebtedness.index','type=merchants') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">التجار</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        @can('view_distributors_repayment')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'distributors') ) != false  ? 'active' : '' }}" href="{{ route('admin.indebtedness.index','type=distributors') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                <span class="menu-title">الموزعين</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        @can('view_admins_repayment')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'admins') ) != false  ? 'active' : '' }}" href="{{ route('admin.indebtedness.index','type=admins') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                <span class="menu-title">المدراء</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                @endcan
                <!--end:Menu item-->
                <!--begin:Menu item-->
                @can('viewWaitingOrders_side_menu')
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ strpos(URL::current(), 'transaction') != false   ? 'here show' : ''}}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
                            <i class="fonticon-app-store"></i>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">طلبات في انتظار الموافقة </span>
                        @if(ordersWaitingToApprove() > 0)
                            <span class="badge badge-light-danger">{{ ordersWaitingToApprove() }}</span>
                        @endif
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion ">

                        <!--begin:Menu item-->
                        @can('view_Indebtedness_banks_transfers')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link " href="{{ route('admin.transaction.index','type=payment') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">تحويلات البنكية للمديونية</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        @can('view_profits_banks_transfers')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link" href="{{ route('admin.transaction.index','type=profits') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                <span class="menu-title">تحويلات بنكية للأرباح</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        @can('view_balance_banks_transfers')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link" href="{{ route('admin.transaction.index','type=recharge') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                <span class="menu-title">تحويلات بنكية للرصيد</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                @endcan
                <!--end:Menu item-->

                <!--begin:Menu item-->
                @can('viewRepayments_side_menu')
                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ strpos(URL::current(), 'users-reports') != false   ? 'here show' : ''}}">
                        <!--begin:Menu link-->
                        <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
                             <i class="fonticon-card"></i>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">تقارير العمليات </span>
                        <span class="menu-arrow"></span>
                    </span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion ">

                            <!--begin:Menu item-->
                            @can('view_merchant_repayment')
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ (strpos(URL::current(), 'merchants') ) != false  ? 'active' : '' }}" href="{{ route('admin.users-reports.index','type=collection') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                        <span class="menu-title">التحصيلات</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endcan
                            <!--end:Menu item-->
                            <!--begin:Menu item-->
                            @can('view_distributors_repayment')
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ (strpos(URL::current(), 'distributors') ) != false  ? 'active' : '' }}" href="{{ route('admin.users-reports.index','type=transfer') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                        <span class="menu-title">التحويلات</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endcan
                            <!--end:Menu item-->
                            <!--begin:Menu item-->
                            @can('view_admins_repayment')
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link {{ (strpos(URL::current(), 'admins') ) != false  ? 'active' : '' }}" href="{{ route('admin.users-reports.index','type=indebtedness') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                        <span class="menu-title">المديونية</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @endcan
                            <!--end:Menu item-->
                        </div>
                        <!--end:Menu sub-->
                    </div>
                @endcan
                <!--end:Menu item-->

                @can('viewProcesses_side_menu')
                <!--begin:Menu item-->
                <div class="menu-item pt-5">
                    <!--begin:Menu content-->
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-7">إدارة العمليات</span>
                    </div>
                    <!--end:Menu content-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ strpos(URL::current(), 'processes') != false   ? 'here show' : ''}}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
                            <i class="fonticon-layers"></i>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">العمليات </span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion ">

                        <!--begin:Menu item-->
                        @can('view_merchant_processes')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'merchants') ) != false  ? 'active' : '' }}" href="{{ route('admin.processes.index','type=merchants') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">التجار</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        @can('view_distributors_processes')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'distributors') ) != false  ? 'active' : '' }}" href="{{ route('admin.processes.index','type=distributors') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                <span class="menu-title">الموزعين</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        @can('view_admins_processes')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'admins') ) != false  ? 'active' : '' }}" href="{{ route('admin.processes.index','type=admins') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                <span class="menu-title">المدراء</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
               @endcan
                <!--end:Menu item-->
                <!--begin:Menu item-->
                @can('viewNotifications_side_menu')
                <div class="menu-item pt-5">
                    <!--begin:Menu content-->
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-7">إدارة الاشعارات</span>
                    </div>
                    <!--end:Menu content-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ strpos(URL::current(), 'notifications') != false   ? 'here show' : ''}}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
                            <i class="la la-bell-o"></i>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">الإشعارات </span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion ">

                        <!--begin:Menu item-->
                        @can('send_merchant_notifications')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'merchants') ) != false  ? 'active' : '' }}" href="{{ route('admin.notifications.create','type=merchants') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">ارسال اشعار للتجار</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        @can('send_distributors_notifications')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'distributors') ) != false  ? 'active' : '' }}" href="{{ route('admin.notifications.create','type=distributors') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                <span class="menu-title">ارسال اشعار للموزعين</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
                @endcan
                @can('viewSettings_side_menu')
                <!--begin:Menu item-->
                <div class="menu-item pt-5">
                    <!--begin:Menu content-->
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-7">إعدادات اللوحة</span>
                    </div>
                    <!--end:Menu content-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ strpos(URL::current(), 'settings') != false ||  strpos(URL::current(), 'currencies') != false   ? 'here show' : ''}}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
                         <i class="las la-globe-africa"></i>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">الإعدادات </span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion ">

                        <!--begin:Menu item-->
                        @can('edit_settings')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'settings') ) != false  ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">إعدادت اللوحة</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'country-settings') ) != false  ? 'active' : '' }}" href="{{ route('admin.country-settings.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">إعدادت الدول</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--begin:Menu item-->
                        @can('view_currencies')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'currencies') ) != false  ? 'active' : '' }}" href="{{ route('admin.currencies.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">العملات</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
{{--                        @can('view_currencies')--}}
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'geadia-wallet') ) != false  ? 'active' : '' }}" href="{{ route('admin.geadia-wallet.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">محفظة جيديا</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
{{--                        @endcan--}}
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
                @endcan
                <!--begin:Menu item-->
                @can('viewAccounts_side_menu')
                <div class="menu-item pt-5">
                    <!--begin:Menu content-->
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-7">الحسابات</span>
                    </div>
                    <!--end:Menu content-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ strpos(URL::current(), 'banks') != false ||strpos(URL::current(), 'purchase-orders') != false   ? 'here show' : ''}}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
                           <i class="las la-wallet"></i>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">الحسابات </span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion ">

                        <!--begin:Menu item-->
                        @can('view_storages')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'banks') ) != false  ? 'active' : '' }}" href="{{ route('admin.banks.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">الخزن</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        @can('view_journals')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'journals') ) != false  ? 'active' : '' }}" href="{{ route('admin.journals.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">الدفاتر اليومية</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
                @endcan
                <!--begin:Menu item-->
                @can('viewOutgoings_side_menu')
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ strpos(URL::current(), 'banks') != false ||strpos(URL::current(), 'purchase-orders') != false   ? 'here show' : ''}}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
                           <i class="la la-money"></i>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">المصروفات </span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion ">

                        <!--begin:Menu item-->
                        @can('view_outgoings')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'outgoings') ) != false  ? 'active' : '' }}" href="{{ route('admin.outgoings.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">المصروفات</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        @can('create_outgoings')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'outgoings') ) != false  ? 'active' : '' }}" href="{{ route('admin.outgoings.create') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">اضافة مصروف</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                @endcan
                <!--end:Menu item-->
                @can('viewPurchases_side_menu')
                <!--begin:Menu item-->
                <div class="menu-item pt-5">
                    <!--begin:Menu content-->
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase fs-7">المشتريات</span>
                    </div>
                    <!--end:Menu content-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ strpos(URL::current(), 'suppliers') != false ||strpos(URL::current(), 'purchase-orders') != false   ? 'here show' : ''}}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
                            <i class="lab la-centos"></i>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">المشتريات </span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion ">

                        <!--begin:Menu item-->
                        @can('view_suppliers')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ (strpos(URL::current(), 'suppliers') ) != false  ? 'active' : '' }}" href="{{ route('admin.suppliers.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">الموردين</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        @can('view_purchase_orders')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link " href="{{ route('admin.purchase-orders.index','type=drafts') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">أوامر الشراء(RFQ)</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        @can('view_invoices')
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link " href="{{ route('admin.purchase-orders.index','type=confirm') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">الفواتير</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        @endcan
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
                @endcan



            </div>
            <!--end::Menu-->
        </div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::sidebar menu-->

</div>
<!--end::Sidebar-->
