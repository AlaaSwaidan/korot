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
                               value="{{old('name',isset($role) ? $role->name:'')}}" required>

                        @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif

                    </div>

                    <div class="form-group col-md-3">

                        <label class="col-form-label">تحديد الكل</label>

                        <div class="checkbox checkbox-primary mb-2">
                            <input type="checkbox" id="check_all" onclick="checkAll()">
                            <label for="check_all">
                                مفعل/غير مفعل
                            </label>
                        </div>
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

                            <h5 class="text-primary float-left mt-0">
                                <div class="checkbox checkbox-primary mb-2">
                                    <input type="checkbox" id="switch-all-{{ $module->id }}"
                                           onclick="checkAllModule('{{$module->id}}')" class="for_check_all">
                                    <label for="switch-all-{{ $module->id }}">تحديد الكل</label>
                                </div>
                            </h5>
                            <div class="d-flex flex-column text-gray-600">

                                @foreach ($module->permissions as $permission)

                                    @can($permission->name)

                                        <div class="ribbon-content">

                                            <div class="checkbox checkbox-primary mb-2">
                                                <input type="checkbox" id="switch-s-1_{{ $permission->id }}" name="permissions[]"
                                                       value="{{$permission->id}}"
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

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <button type="submit" class="btn btn-primary waves-effect waves-light">حفظ</button>

                <a href="{{ route('admin.roles.index') }}">
                    <button type="button" class="btn btn-danger">الغاء</button>
                </a>

            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>

