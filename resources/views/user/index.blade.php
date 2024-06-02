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
                @lang('user.user')
            @endslot
            @slot('breadcrumb1')
                @lang('common.dashboard')
            @endslot
            @slot('breadcrumb1_link')
                {{ route('dashboard') }}
            @endslot
            @if (\App\Traits\RolePermissionTrait::checkRoleHasPermission('user', 'create'))
                @slot('action_button1')
                    @lang('common.add_new')
                @endslot
                @slot('action_button1_link')
                    {{ route('user.create') }}
                @endslot
            @endif
            @slot('action_button1_class')
                btn-primary
            @endslot
        @endcomponent

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="header-title">Users</h4>
                        <ul class="nav nav-tabs nav-bordered mb-3">
                            <li class="nav-item">
                                <a href="#users-tab-all" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                    All
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#users-tab-deleted" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                    Deleted
                                </a>
                            </li>
                        </ul> <!-- end nav-->
                        <div class="tab-content">
                            <div class="tab-pane show active" id="users-tab-all">
                                <table id="datatable-users-all" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Avatar</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div> <!-- end all-->

                            <div class="tab-pane" id="users-tab-deleted">
                                <table id="datatable-users-deleted" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Avatar</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div> <!-- end deleted-->
                        </div> <!-- end tab-content-->

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

    <script>
        window.onload = function(e) {
            $(".destroy[data-id='{{ Auth::user()->id }}']").hide()
        }
        $(function() {

            let datatable_columns = [{
                    data: 'DT_RowIndex',
                    name: "DT_RowIndex",
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'picture',
                    name: 'picture',
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'email',
                    name: 'email',
                },
                {
                    data: 'mobile',
                    name: 'mobile',
                },
                {
                    data: 'status',
                    name: 'status',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]

            let datatable_columns_defs = [{
                    'bSortable': true,
                    'aTargets': [0, 1, 2, 3]
                },
                {
                    'bSearchable': false,
                    'aTargets': [0]
                },
                {
                    className: 'text-center',
                    targets: [0, 3, 4]
                },
            ]

            $('#datatable-users-all').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 25,
                serverMethod: 'get',
                lengthMenu: [10, 25, 50, 100],
                order: [0, "asc"],
                language: {
                    'loadingRecords': '&nbsp;',
                    'processing': 'Loading ...'
                },
                ajax: {
                    url: '{{ route('user.index') }}',
                    type: 'get',
                    dataType: 'JSON',
                    cache: false,
                },
                columns: datatable_columns,
                search: {
                    "regex": true
                },
                columnDefs: datatable_columns_defs,
            });

            $('#datatable-users-deleted').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 25,
                serverMethod: 'get',
                lengthMenu: [10, 25, 50, 100],
                order: [0, "asc"],
                language: {
                    'loadingRecords': '&nbsp;',
                    'processing': 'Loading ...'
                },
                ajax: {
                    url: '{{ route('user.deleted_list') }}',
                    type: 'get',
                    dataType: 'JSON',
                    cache: false,
                },
                columns: datatable_columns,
                search: {
                    "regex": true
                },
                columnDefs: datatable_columns_defs,
            });

        })

        function statusChange(id) {
            statusUpdate(id, '{{ route('user.status') }}')
        }
    </script>

    @include('components.delete_script')
@endpush
