<!--begin::Card body-->
<div class="tab-pane fade show active" id="kt_table_widget_6_tab_1">
    <!--begin::Header-->
    <div class="card-header border-0 pt-5">
        <div class="card-toolbar">
            <ul class="nav">
                @foreach(siteLanguages() as $key => $language)
                    <li class="nav-item" @if($key == 'ar') role="presentation" @endif>
                        <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-secondary fw-bold px-4 me-1 {{ $key == 'ar' ? 'active' : '' }}" data-bs-toggle="tab" href="#tab_{{ $key }}" aria-selected="true" role="tab">{{ $language }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="card-body py-3">
        <div class="tab-content">
            @foreach(siteLanguages() as $key => $language)
                <div class="tab-pane {{ $key == 'ar' ? 'fade show active' : '' }}" id="tab_{{ $key }}">

                    <!--begin::Input group-->
                    <div class="fv-row row mb-15">
                        <!--begin::Col-->
                        <div class="col-md-3 d-flex align-items-center">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold">الاسم</label>
                            <!--end::Label-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-9">

                            {!! Form::text("name[$key]", isset($store) ? $store->name[$key] : null, ['class'=> 'form-control form-control-lg form-control-solid', 'placeholder'=> $language]) !!}

                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                </div>

            @endforeach
        </div>
    </div>

    <!--end::Header-->

</div>
<!--end::Card body-->
<!--begin::Tap pane-->
<div class="tab-pane fade" id="kt_table_widget_6_tab_2">
    <!--begin::Input group-->
    <div class="fv-row row mb-15">
        <!--begin::Col-->
        <div class="col-md-3 d-flex align-items-center">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold">الترتيب</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"  class="form-control form-control-lg form-control-solid" name="arrangement" placeholder="الترتيب"
                   value="{{ isset($store) ? $store->arrangement : old('arrangement') }}">
            <!--end::Input-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row row mb-15">
        <!--begin::Col-->
        <div class="col-md-3 d-flex align-items-center">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold">اللون</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            {!! Form::color('color', isset($store->color) ? $store->color : null, ['class'=> 'form-control form-control-lg form-control-solid', 'id'=> 'color']) !!}

            <!--end::Input-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row row mb-15">
        <!--begin::Col-->
        <div class="col-md-3">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold mt-2">التجار</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <select name="merchant_ids[]" aria-label="اختر التجار" data-hide-search="true" data-control="select2" data-placeholder="اختر التجار" class="form-select mb-2" multiple>
                <option></option>
                @foreach($merchants as $merchant)
                    <option value="{{ $merchant->id }}" {{  isset($store) && in_array($merchant->id,$merchantIds) ? 'selected' : '' }}>{{ $merchant->name.' - '.$merchant->phone }}</option>
                @endforeach

            </select>
            <!--end::Input-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row row mb-15">
        <!--begin::Col-->
        <div class="col-md-3 d-flex align-items-center">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold">الصورة </label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Image input-->
        <div class="col-md-9">
            <div class="image-input image-input-outline image-input-placeholder" data-kt-image-input="true">
                <!--begin::Preview existing avatar-->
                <div class="image-input-wrapper w-125px h-125px" @if(isset($store)) style="background-image: url({{ $store->image_full_path }});" @endif></div>
                <!--end::Preview existing avatar-->
                <!--begin::Label-->
                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                    <i class="bi bi-pencil-fill fs-7"></i>
                    <!--begin::Inputs-->
                    <input type="file" name="photo" accept=".png, .jpg, .jpeg" />
                    <input type="hidden" name="avatar_remove" />
                    <!--end::Inputs-->
                </label>
                <!--end::Label-->
                <!--begin::Cancel-->
                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                    <i class="bi bi-x fs-2"></i>
                </span>
                <!--end::Cancel-->
                <!--begin::Remove-->
                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                    <i class="bi bi-x fs-2"></i>
                </span>
                <!--end::Remove-->
            </div>
        </div>
        <!--end::Image input-->
    </div>
    <!--end::Input group-->

    <!--begin::Input group-->
    <div class="fv-row row mb-15">
        <!--begin::Col-->
        <div class="col-md-3 d-flex align-items-center">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold">مربوطة بال API</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Switch-->
            <div class="form-check form-switch form-check-custom form-check-solid me-10">
                <input class="form-check-input h-30px w-50px" name="api_linked" type="checkbox" value="1" {{ isset($store) ?( $store->api_linked ? "checked" : '') : '' }} id="autotimezone" />
                <label class="form-check-label" for="autotimezone">مربوط</label>
            </div>
            <!--begin::Switch-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row row mb-15">
        <!--begin::Col-->
        <div class="col-md-3 d-flex align-items-center">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold">مربوطة بال Like Card API</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Switch-->
            <div class="form-check form-switch form-check-custom form-check-solid me-10">
                <input class="form-check-input h-30px w-50px" name="like_card_linked" type="checkbox" value="1" {{ isset($store) ?( $store->like_card_linked ? "checked" : '') : '' }} id="autotimezone1" />
                <label class="form-check-label" for="autotimezone1">مربوط</label>
            </div>
            <!--begin::Switch-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Input group-->
</div>
<!--end::Tap pane-->

<!--begin::Action buttons-->
<div class="row mt-12">
    <div class="col-md-9 offset-md-3">
        <!--begin::Button-->
        <button type="submit" class="btn btn-primary" >
            <span class="indicator-label">حفظ</span>

        </button>
        <!--end::Button-->
    </div>
</div>
<!--begin::Action buttons-->
