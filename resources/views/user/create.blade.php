@extends('layouts.master')

@section('title')
    @lang('user.create_title')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1_link')
            {{ route('user.index') }}
        @endslot
        @slot('li_1')
            @lang('user.index_title')
        @endslot
        @slot('li_2')
            @lang('user.create_title')
        @endslot
        @slot('title')
            @lang('user.create_title')
        @endslot
    @endcomponent

    @php
        $branch = App\Models\branch_info::all();
    @endphp

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{route('user.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 py-2">
                                <label class="form-label fw-bold" for="name">Branch</label>
                                <select class="form-control" name="branch" id="branch" required>
                                    <option>--Select One--</option>
                                    @if($branch)
                                    @foreach ($branch as $v)
                                        <option value="{{$v->id}}">{{$v->branch_name_en}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 py-2">
                                <label class="form-label fw-bold" for="name">@lang('common.name')</label>
                                <input name="name" type="text" class="form-control" id="name" placeholder="Type User Name"
                                     required>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 py-2">
                                <label class="form-label fw-bold" for="email">@lang('common.email')</label>
                                <input name="email" type="text" class="form-control" id="email" placeholder="Type User Email"
                                     required>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 py-2">
                                <label class="form-label fw-bold" for="mobile">@lang('common.mobile')</label>
                                <input name="mobile" type="text" class="form-control" id="mobile" placeholder="Type User Mobile"
                                    >
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 py-2">
                                <label class="form-label fw-bold" for="userdob">@lang('common.dob')</label>
                                <input name="dob" type="text" class="form-control @error('dob') is-invalid @enderror"
                                    placeholder="dd-mm-yyyy" data-date-format="dd-mm-yyyy" data-date-container='#datepicker1'
                                    data-date-end-date="0d" value=""
                                    data-provide="datepicker" autofocus id="dob">
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 py-2">
                                <label class="form-label fw-bold" for="role_id">@lang('user.role')</label>
                                <div class="form-group">
                                    {{ Form::select('role_id', $roles, @$user->user_roles?->first()->id, ['class' => @$error_class . 'form-control select2', 'id' => 'role_id', 'placeholder' => trans('common.select_one'), 'required']) }}
                                    @if ($errors->has('role_id'))
                                        <p class="text-danger">{{ $errors->first('role_id') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 py-2">
                                <label class="form-label fw-bold" for="password">@lang('common.password')</label>
                                <input name="password" type="text" class="form-control" id="password" placeholder="Type User Password"
                                    value="" required>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 py-2">
                                <label for="image">@lang('user.image')</label>
                                <input type="file" class="form-control" name="image" id="image">
                            </div>
                        </div>
                        <div class="col-12">
                            <input type="submit" class="btn btn-sm btn-success" value="@lang('common.submit')">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
