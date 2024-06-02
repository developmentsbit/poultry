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
            @lang('asset_cost.create_title')
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
                {{ route('asset_cost.index') }}
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
                    <form method="post" action="{{ route('asset_cost.store') }}">
                        @csrf
                        <div class="from-group row">
                            <div class="col-lg-4 col-md-4 col-12">
                                <label for="date">@lang('asset_cost.date')</label><span class="text-danger">*</span>
                                <input type="text" class="form-control form-control-sm" name="date" id="datepicker" required autocomplete="off" value="{{ date('d/m/Y') }}">
                            </div>
                            <div class="col-lg-4 col-md-4 col-12">
                                <label for="title_id">@lang('asset_cost.title')</label><span class="text-danger">*</span>
                                <select class="form-select form-select-sm" name="title_id" id="title_id" required>
                                    <option value="">@lang('common.select_one')</option>
                                    @if(isset($category))
                                    @foreach ($category as $c)
                                    <option value="{{ $c->id }}">
                                    @if(config('app.locale') == 'en')
                                    {{ $c->title_en ?: $c->title_bn }}
                                    @else
                                    {{ $c->title_bn ?: $c->title_en }}
                                    @endif
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-lg-4 col-md-4 col-12">
                                <label for="amount">@lang('asset_cost.amount')</label><span class="text-danger">*</span>
                                <input type="number" class="form-control form-control-sm" name="amount" id="amount" required autocomplete="off" value="" required>
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

<script>
    $('#datepicker').datepicker({
        uiLibrary: 'bootstrap4',
        format : 'dd/mm/yyyy',
    });

</script>
@endpush
