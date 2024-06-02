<div class="row mb-3">
    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 my-2">
        @php /** @var string $errors */ $error_class = $errors->has('parent_id') ? 'parsley-error ' : ''; @endphp
        <label for="parent_id" class="form-label font-weight-bold">@lang('menu.label_parent_id')</label>
        <div class="form-group">
            {{ Form::select('parent_id', $menus, null, ['class' => $error_class . 'form-control select2', 'id' => 'parent_id', 'placeholder' => trans('menu.label_select_parent_id')]) }}
            @if ($errors->has('parent_id'))
            <p class="text-danger">{{ $errors->first('parent_id') }}</p>
            @endif
        </div>
    </div>

    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 my-2">
        @php /** @var string $errors */ $error_class = $errors->has('name') ? 'parsley-error ' : ''; @endphp
        <label for="name" class="form-label font-weight-bold">@lang('menu.label_name')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group">
            {{ Form::text('name', null, ['class' => $error_class . 'form-control', 'id' => 'name', 'required' => 1]) }}
            @if ($errors->has('name'))
            <p class="text-danger">{{ $errors->first('name') }}</p>
            @endif
        </div>
    </div>

    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 my-2">
        @php /** @var string $errors */ $error_class = $errors->has('bn_name') ? 'parsley-error ' : ''; @endphp
        <label for="bn_name" class="form-label font-weight-bold">@lang('menu.label_bn_name')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group">
            {{ Form::text('bn_name', null, ['class' => $error_class . 'form-control', 'id' => 'bn_name', 'required' => 1]) }}
            @if ($errors->has('bn_name'))
            <p class="text-danger">{{ $errors->first('bn_name') }}</p>
            @endif
        </div>
    </div>

    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 my-2">
        @php /** @var string $errors */ $error_class = $errors->has('system_name') ? 'parsley-error ' : ''; @endphp
        <label for="system_name" class="form-label font-weight-bold">@lang('menu.label_system_name')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group">
            {{ Form::text('system_name', null, ['class' => $error_class . 'form-control', 'id' => 'system_name', 'required' => 1]) }}
            @if ($errors->has('system_name'))
            <p class="text-danger">{{ $errors->first('system_name') }}</p>
            @endif
        </div>
    </div>

    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 my-2">
        @php /** @var string $errors */ $error_class = $errors->has('route_name') ? 'parsley-error ' : ''; @endphp
        <label for="route_name" class="form-label font-weight-bold">@lang('menu.label_route_name')</label>
        <div class="form-group">
            {{ Form::text('route_name', null, ['class' => $error_class . 'form-control', 'id' => 'route_name', 'required' => false]) }}
            @if ($errors->has('route_name'))
            <p class="text-danger">{{ $errors->first('route_name') }}</p>
            @endif
        </div>
    </div>

    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 my-2">
        @php /** @var string $errors */ $error_class = $errors->has('icon') ? 'parsley-error ' : ''; @endphp
        <label for="icon" class="form-label font-weight-bold">@lang('menu.label_icon')</label>
        <div class="form-group">
            {{ Form::text('icon', null, ['class' => $error_class . 'form-control', 'id' => 'icon', 'placeholder' => 'fa fa-bars']) }}
            @if ($errors->has('icon'))
            <p class="text-danger">{{ $errors->first('icon') }}</p>
            @endif
        </div>
    </div>

    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 my-2">
        @php /** @var string $errors */ $error_class = $errors->has('order_by') ? 'parsley-error ' : ''; @endphp
        <label for="order_by" class="form-label font-weight-bold">@lang('menu.label_order_by')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group">
            {{ Form::number('order_by', null, ['class' => $error_class . 'form-control', 'min' => 1, 'id' => 'order_by', 'required' => 1]) }}
            @if ($errors->has('order_by'))
            <p class="text-danger">{{ $errors->first('order_by') }}</p>
            @endif
        </div>
    </div>

    {{-- <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 my-2">
        @php /** @var string $errors */
         $error_class = $errors->has('role_id') ? 'parsley-error ' : ''; @endphp
        <label for="role_id" class="form-label font-weight-bold">@lang('menu.label_role_id')</label>
        <div class="form-group">
            {{ Form::select('role_id', $roles, null, ['class' => $error_class.'form-control select2', 'id' => 'role_id', 'placeholder' => trans('menu.label_select_one')]) }}
    @if ($errors->has('role_id'))
    <p class="text-danger">{{$errors->first('role_id')}}</p>
    @endif
</div>
</div> --}}

<div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 my-2">
    @php /** @var string $errors */ $error_class = $errors->has('menu_type') ? 'parsley-error ' : ''; @endphp
    <label for="menu_type" class="form-label font-weight-bold">@lang('menu.label_menu_type')</label>
    <sup class="text-danger">*</sup>
    <div class="form-group form-group-check pl-4">

        <div class="form-check-custom">
            {{ Form::radio('menu_type', 'Parent', null, ['class' => 'form-check-input', 'id' => 'menu_type_parent', 'required' => 1, 'checked' => @$menu->menu_type == 'Parent' ? true : ((!isset($menu->menu_type)) ? true : false )]) }}
            <label class="form-check-label" for="menu_type_parent">
                @lang('menu.label_menu_type_parent')
            </label>
        </div>

        <div class="form-check-custom">
            {{ Form::radio('menu_type', 'Module', null, ['class' => 'form-check-input', 'id' => 'menu_type_module', 'required' => 1, 'checked' => @$menu->menu_type == 'Module' ? true : false]) }}
            <label class="form-check-label" for="menu_type_module">
                @lang('menu.label_menu_type_module')
            </label>
        </div>

        <div class="form-check-custom">
            {{ Form::radio('menu_type', 'Single', null, ['class' => 'form-check-input', 'id' => 'menu_type_single', 'required' => 1, 'checked' => @$menu->menu_type == 'Single' ? true : false]) }}
            <label class="form-check-label" for="menu_type_single">
                @lang('menu.label_menu_type_single')
            </label>
        </div>

        @if ($errors->has('menu_type'))
        <p class="text-danger">{{ $errors->first('menu_type') }}</p>
        @endif
    </div>
</div>

<div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 my-2">
    @php /** @var string $errors */ $error_class = $errors->has('create_permissions') ? 'parsley-error ' : ''; @endphp
    <label for="create_permissions" class="form-label font-weight-bold">@lang('menu.label_create_permissions')</label>
    <sup class="text-danger">*</sup>
    <div class="form-group form-group-check pl-4">
        <div class="form-check-custom">
            {{ Form::radio('create_permissions', 'Yes', null, ['class' => 'form-check-input', 'id' => 'create_permissions_yes', 'required' => 1, 'checked' => @$menu->create_permissions == 'Yes' ? true : false]) }}
            <label class="form-check-label" for="create_permissions_yes">
                @lang('menu.label_create_permissions_yes')
            </label>
        </div>

        <div class="form-check-custom">
            {{ Form::radio('create_permissions', 'No', null, ['class' => 'form-check-input', 'id' => 'create_permissions_no', 'required' => 1, 'checked' => @$menu->create_permissions == 'Yes' ? false : true]) }}
            <label class="form-check-label" for="create_permissions_no">
                @lang('menu.label_create_permissions_no')
            </label>
        </div>
        @if ($errors->has('create_permissions'))
        <p class="text-danger">{{ $errors->first('create_permissions') }}</p>
        @endif
    </div>
</div>

<div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 my-2">
    @php /** @var string $errors */ $error_class = $errors->has('is_hidden') ? 'parsley-error ' : ''; @endphp
    <label for="is_hidden" class="form-label font-weight-bold">@lang('menu.label_is_hidden')</label>
    <sup class="text-danger">*</sup>
    <div class="form-group form-group-check pl-4">
        <div class="form-check-custom">
            {{ Form::radio('is_hidden', 'Yes', null, ['class' => 'form-check-input', 'id' => 'is_hidden_yes', 'required' => 1]) }}
            <label class="form-check-label" for="is_hidden_yes">
                @lang('menu.label_is_hidden_yes')
            </label>
        </div>

        <div class="form-check-custom">
            {{ Form::radio('is_hidden', 'No', null, ['class' => 'form-check-input', 'id' => 'is_hidden_no', 'required' => 1, 'checked' => @$menu->is_hidden == 'Yes' ? false : true]) }}
            <label class="form-check-label" for="is_hidden_no">
                @lang('menu.label_is_hidden_no')
            </label>
        </div>
        @if ($errors->has('is_hidden'))
        <p class="text-danger">{{ $errors->first('is_hidden') }}</p>
        @endif
    </div>
</div>

<div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 my-2">
    @php /** @var string $errors */ $error_class = $errors->has('status') ? 'parsley-error ' : ''; @endphp
    <label for="status" class="form-label font-weight-bold">@lang('menu.label_status')</label>
    <sup class="text-danger">*</sup>
    <div class="form-group form-group-check pl-4">
        <div class="form-check-custom">
            {{ Form::radio('status', '1', null, ['class' => 'form-check-input', 'id' => 'active', 'required' => 1, 'checked' => 1]) }}
            <label class="form-check-label" for="active">
                @lang('menu.label_status_active')
            </label>
        </div>

        <div class="form-check-custom">
            {{ Form::radio('status', '0', null, ['class' => 'form-check-input', 'id' => 'inactive', 'required' => 1]) }}
            <label class="form-check-label" for="inactive">
                @lang('menu.label_status_inactive')
            </label>
        </div>
        @if ($errors->has('status'))
        <p class="text-danger">{{ $errors->first('status') }}</p>
        @endif
    </div>
</div>

<br>
<br>
<br>
<br>
<br>
</div>


<h5 class="d-inline-block">
    <strong>@lang('menu.menu_actions')</strong>
</h5>

<div class="border border-secondary mb-4 p-4">
    <div class="row">
        @foreach ($actions as $action)
        <div class="col-sm-12 col-md-4 col-lg-3 my-2 {{ $error_class }}">
            <label for="{{ $action->slug }}" class="font-size-15 font-weight-semibold" for="create" style="cursor: pointer;">
                {{ Form::checkbox('actions[' . $action->slug . ']', 'yes', false, ['id' => $action->slug, 'class' => 'form-check-input']) }}
                @lang('menu.' . $action->slug . '_action')
            </label>
            @if ($errors->has($action->slug))
            <p class="text-danger">{{ $errors->first($action->slug) }}</p>
            @endif
        </div>
        @endforeach
        @if (!@$menu)
        <div class="col-sm-12 col-md-4 col-lg-3 my-2 {{ $error_class }}">
            <label class="font-size-15 font-weight-semibold" for="deleted_list" style="cursor: pointer;">
                {{ Form::checkbox('actions[deleted_list]', 'yes', false, ['id' => 'deleted_list', 'class' => 'form-check-input']) }}
                @lang('menu.deleted_list_action')
            </label>
            @if ($errors->has('deleted_list'))
            <p class="text-danger">{{ $errors->first('deleted_list') }}</p>
            @endif
        </div>
        <div class="col-sm-12 col-md-4 col-lg-3 my-2 {{ $error_class }}">
            <label class="font-size-15 font-weight-semibold" for="restore" style="cursor: pointer;">
                {{ Form::checkbox('actions[restore]', 'yes', false, ['id' => 'restore', 'class' => 'form-check-input']) }}
                @lang('menu.restore_action')
            </label>
            @if ($errors->has('restore'))
            <p class="text-danger">{{ $errors->first('restore') }}</p>
            @endif
        </div>
        <div class="col-sm-12 col-md-4 col-lg-3 my-2 {{ $error_class }}">
            <label class="font-size-15 font-weight-semibold" for="permanent_delete" style="cursor: pointer;">
                {{ Form::checkbox('actions[permanent_delete]', 'yes', false, ['id' => 'permanent_delete', 'class' => 'form-check-input']) }}
                @lang('menu.permanent_delete_action')
            </label>
            @if ($errors->has('permanent_delete'))
            <p class="text-danger">{{ $errors->first('permanent_delete') }}</p>
            @endif
        </div>
        @endif
    </div>
</div>


<div class="row">
    <div class="col-md-12 text-right">
        <button type="submit" class="btn btn-primary waves-effect waves-light">
            <i class="fa fa-save"></i> @lang('menu.label_submit_button')
        </button>
    </div>
</div>

@section('script')
<script src="{{ URL::asset('/assets/common/libs/parsleyjs/parsleyjs.min.js') }}"></script>

<script src="{{ URL::asset('/assets/common/js/pages/form-validation.init.js') }}"></script>
@endsection
