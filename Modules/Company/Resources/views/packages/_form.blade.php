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

                            {!! Form::text("name[$key]", isset($package) ? $package->name[$key] : null, ['class'=> 'form-control form-control-lg form-control-solid', 'placeholder'=> $language]) !!}

                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row row mb-15">
                        <!--begin::Col-->
                        <div class="col-md-3 d-flex align-items-center">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold">التفاصيل</label>
                            <!--end::Label-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-9">

                            {!! Form::textarea("description[$key]", isset($package) && $package->description ? $package->description[$key] : null, ['class'=> 'form-control form-control-lg form-control-solid','rows'=>10, 'placeholder'=> $language]) !!}

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
            <label class="fs-6 fw-semibold">باركود</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text" id="barcode"  class="form-control form-control-lg form-control-solid" name="barcode" placeholder="باكود"
                   value="{{ isset($package) ? $package->barcode : old('barcode') }}">
            <!--end::Input-->
        </div>
        <!--end::Col-->

        <div class="col-4">
            <a class="btn btn-success" onclick="add_code()" style="color:#ffff;" >
                انشاء باركود
            </a>
        </div>

    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row row mb-15">
        <!--begin::Col-->
        <div class="col-md-3 d-flex align-items-center">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold">Gencode</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"  class="form-control form-control-lg form-control-solid" name="gencode" placeholder="gencode"
                   value="{{ isset($package) ? $package->gencode : old('gencode') }}">
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
            <label class="fs-6 fw-semibold">حالة Gencode</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Switch-->
            <div class="form-check form-switch form-check-custom form-check-solid me-10">
                <input class="form-check-input h-30px w-50px" name="gencode_status" type="checkbox" value="1" {{ isset($package) ?( $package->gencode_status ? "checked" : '') : '' }} id="gencode_status" />
                <label class="form-check-label" for="gencode_status">مفعل</label>
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
            <label class="fs-6 fw-semibold">Gencode for like card</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"  class="form-control form-control-lg form-control-solid" name="gencode_like_card" placeholder="gencode for like card"
                   value="{{ isset($package) ? $package->gencode_like_card : old('gencode_like_card') }}">
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
            <label class="fs-6 fw-semibold">حالة LikeCard</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Switch-->
            <div class="form-check form-switch form-check-custom form-check-solid me-10">
                <input class="form-check-input h-30px w-50px" name="gencode_like_card_status" type="checkbox" value="1" {{ isset($package) ?( $package->gencode_like_card_status ? "checked" : '') : '' }} id="gencode_like_card_status" />
                <label class="form-check-label" for="gencode_like_card_status">مفعل</label>
            </div>
            <!--begin::Switch-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Input group-->
    <hr>
    <!--begin::Input group-->
    <div class="fv-row row mb-15">
        <!--begin::Col-->
        <div class="col-md-3 d-flex align-items-center">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold">Product Id for Zain</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"  class="form-control form-control-lg form-control-solid" name="product_id_zain" placeholder="Product Id for Zain"
                   value="{{ isset($package) ? $package->product_id_zain : old('product_id_zain') }}">
            <!--end::Input-->
        </div>
        <!--end::Col-->
    </div>
    <!--begin::Input group-->
    <div class="fv-row row mb-15">
        <!--begin::Col-->
        <div class="col-md-3 d-flex align-items-center">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold">Price Id for Zain</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"  class="form-control form-control-lg form-control-solid" name="price_zain" placeholder="Price for Zain"
                   value="{{ isset($package) ? $package->price_zain : old('price_zain') }}">
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
            <label class="fs-6 fw-semibold">حالة Zain</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Switch-->
            <div class="form-check form-switch form-check-custom form-check-solid me-10">
                <input class="form-check-input h-30px w-50px" name="zain_status" type="checkbox" value="1" {{ isset($package) ?( $package->zain_status ? "checked" : '') : '' }} id="zain_status" />
                <label class="form-check-label" for="zain_status">مفعل</label>
            </div>
            <!--begin::Switch-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Input group-->

    <hr>

    <!--begin::Input group-->
    <div class="fv-row row mb-15">
        <!--begin::Col-->
        <div class="col-md-3 d-flex align-items-center">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold">سعر البطاقة</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"  class="form-control form-control-lg form-control-solid" name="card_price" placeholder="سعر البطاقة"
                   value="{{ isset($package) ? $package->card_price : old('card_price') }}">
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
            <label class="fs-6 fw-semibold">التكلفة</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"  class="form-control form-control-lg form-control-solid" name="cost" placeholder="التكلفة"
                   value="{{ isset($package) ? $package->cost : old('cost') }}">
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
            <label class="fs-6 fw-semibold">الترتيب</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Input-->
            <input type="text"  class="form-control form-control-lg form-control-solid" name="arrangement" placeholder="الترتيب"
                   value="{{ isset($package) ? $package->arrangement : old('arrangement') }}">
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
            <label class="fs-6 fw-semibold">الحالة</label>
            <!--end::Label-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-9">
            <!--begin::Switch-->
            <div class="form-check form-switch form-check-custom form-check-solid me-10">
                <input class="form-check-input h-30px w-50px" name="status" type="checkbox" value="1" {{ isset($package) ?( $package->status ? "checked" : '') : '' }} id="autotimezone" />
                <label class="form-check-label" for="autotimezone">مفعل</label>
            </div>
            <!--begin::Switch-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <label class="fs-6 fw-semibold">ثمن البطاقة</label>
      @foreach(cardsType() as $key => $value)
        <div class="row g-9 mb-5">
            <!--begin::Col-->
            <div class="col-md-3 d-flex align-items-center">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold">{{ $value }}</label>
                <!--end::Label-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-6 fv-row fv-plugins-icon-container">
                <!--begin::Input-->
                <input class="form-control form-control-solid" placeholder="{{ $value }}" name="type[{{$key}}]" value="{{ isset($package) && $price->where('type',$key)->first() ? $price->where('type',$key)->first()->price : null }}">
                <!--end::Input-->
            </div>
            <!--end::Col-->
        </div>
      @endforeach

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
