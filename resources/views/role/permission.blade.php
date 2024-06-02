@extends('layouts.master')

@section('title') @lang('role.permission_title') @endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1_link'){{route('role.index')}}@endslot
@slot('li_1')@lang('role.index_title')@endslot
@slot('li_2')@lang('role.permission_title')@endslot
@slot('title')@lang('role.permission_title')@endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">@lang('role.role_permission_edit')</h4>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <div class="form-validation">
                        @if($errors->any())
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Danger:">
                                <use xlink:href="#exclamation-triangle-fill" /></svg>
                            <div>
                                {{ $errors->first() }}
                            </div>
                        </div>
                        @endif
                        {{--<form id="form" class="form-valide" action="{{ route('role.update',$role->id) }}" method="post">
                        @csrf
                        @method('patch')
                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label class="font-weight-bold" for="name">@lang('common.name')<span class="text-danger">*</span></label>
                                <div>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="@lang('role.enter_role_name')" value="{{ @$role->name }}">
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="font-weight-bold" for="status">@lang('common.status')<span class="text-danger">*</span></label>
                                <div>
                                    <select class="form-control" id="status" name="status">
                                        <option value="1" @if($role->status == 1) selected @endif>@lang('common.active')</option>
                                        <option value="0" @if($role->status == 0) selected @endif>@lang('common.inactive')</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <button type="submit" class="btn mr-2 btn-primary">@lang('common.submit')</button>
                        <a href="{{ route('role.index') }}"><button type="button" class="btn btn-light">@lang('common.cancel')</button></a>
                        </form>--}}
                        {{ Form::model($role,['url' => route('role.permission.store',$role->id), 'method' => 'post','class' => 'custom-validation']) }}
                        <div class="row">
                            {{--<div class="col-xs-12 col-sm-12 col-md-12">
                                    <input type="checkbox" id="select_all" {{$menus_count+count($user_menu_action) == count($menu_permission)+count($menu_action_permission) ? 'checked':''}}>
                            <label class="font-weight-bold" for="select_all" class="menu_label">Select All</label>
                        </div>--}}
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <h3>All Permissions: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label class="font-weight-bold" style="font-size: 20px;" for="checkAll">
                                    <input type="checkbox" {{ $all_permissions == count($rolePermissions) ? 'checked' : '' }} id="checkAll" name="checkAll">&nbsp; Select All
                                </label>
                            </h3>

                            @foreach($permission_groups as $key => $permissions)
                            @php
                            //if($key == 'Menu' && $role->id != 1) continue;
                            @endphp
                            <div class="card my-2">
                                <div class="card-header">
                                    <strong class="text-uppercase">{{ $key }}</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach($permissions as $permission)
                                        <div class="col-xs-12 col-sm-3 col-md-3">
                                            <div class="custom-control custom-checkbox mb-2">
                                                <label>{{ Form::checkbox('permission[]', $permission->id, in_array($permission->id, $rolePermissions) ? true : false, array('class' => 'name custom-control-input permission-checkbox')) }}
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{--@include('backend.permission.permission_item')--}}

                    <div class="row mb-1">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                <i class="fa fa-save"></i> @lang('common.submit')
                            </button>
                        </div>
                    </div>

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@endsection

@push('footer_scripts')
<script>
    $(function() {
        $('body').on('click', function() {
            let checked = 0
            let unchecked = 0
            $('.permission-checkbox').each(function() {
                if (this.checked) {
                    checked++
                } else {
                    unchecked++
                }
            })

            if (unchecked === 0) {
                $('#checkAll').prop('checked', true)
            } else {
                $('#checkAll').prop('checked', false)
            }
        })

        $('#checkAll').on('click', function() {
            if ($('#checkAll').is(':checked')) {
                $('.permission-checkbox').each(function() {
                    this.checked = true
                })
            } else {
                $('.permission-checkbox').each(function() {
                    this.checked = false
                })
            }
        })
    })

</script>
@endpush
