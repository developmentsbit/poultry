@extends('layouts.master')
@push('header_styles')
    <!-- third party css -->
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/buttons.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/select.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <!-- third party css end -->
@endpush
@section('content')
<div class="container">

    @component('components.breadcrumb')
        @slot('title')
            @lang('asset_dep.create_title')
        @endslot
        @slot('breadcrumb1')
            @lang('common.dashboard')
        @endslot
        @slot('breadcrumb1_link')
            {{ route('dashboard') }}
        @endslot
        @if (\App\Traits\RolePermissionTrait::checkRoleHasPermission('role', 'create'))
            @slot('action_button1')
               <i class="fa fa-eye"></i> @lang('common.view')
            @endslot
            @slot('action_button1_link')
                {{ route('asset_depreciation.index') }}
            @endslot
        @endif
        @slot('action_button1_class')
            btn-info
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('asset_depreciation.store') }}">
                        @csrf
                        <div class="from-group row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <label for="title_id">@lang('asset_dep.title')</label><span class="text-danger">*</span>
                                <select class="form-select form-select-sm" name="title_id" required>
                                    <option value="">@lang('common.select_one')</option>
                                    @foreach ($category as $c)
                                    <option value="{{ $c->id }}">{{ $c->title_en }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <label for="depreciation_value">@lang('asset_dep.depreciation_value')</label>
                                <input type="number" class="form-control form-control-sm" name="depreciation_value" id="depreciation_value" required>
                            </div>
                            <div class="col-lg-12 col-md-12 col-12 mt-2">
                                <label for="details">@lang('asset_dep.details')</label>
                                <textarea class="form-control" name="details" id="details"></textarea>
                            </div>
                            <div class="col-12 text-right mt-2" style="text-align: right">
                                <button class="btn btn-sm btn-success"><i class="fa fa-save"></i> @lang('common.submit')</button>
                            </div>
                        </div>
                    </form>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

</div>



@endsection
@push('footer_scripts')
    <!-- third party js -->
    <script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.select.min.js') }}"></script>
    <!-- third party js ends -->

    <!-- demo app -->
    <script src="{{ asset('assets/js/pages/demo.datatable-init.js') }}"></script>
    <!-- end demo js-->
@include('components.delete_script')
@endpush
