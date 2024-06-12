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
            @lang('branch_info.index')
        @endslot
        @slot('breadcrumb1')
            @lang('common.dashboard')
        @endslot
        @slot('breadcrumb1_link')
            {{ route('dashboard') }}
        @endslot
        @if (\App\Traits\RolePermissionTrait::checkRoleHasPermission('role', 'create'))
            @slot('action_button1')
                @lang('common.add_new')
            @endslot
            @slot('action_button1_link')
                {{ route('branch_info.create') }}
            @endslot
        @endif
        @slot('action_button1_class')
            btn-dark
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="header-title">@lang('branch_info.index_title')</h4>
                    <ul class="nav nav-tabs nav-bordered mb-3">
                        <li class="nav-item">
                            <a href="#roles-tab-all" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                All
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#roles-tab-deleted" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                Deleted
                            </a>
                        </li>
                    </ul> <!-- end nav-->
                    <div class="tab-content">
                        <div class="tab-pane show active" id="roles-tab-all">
                            <table id="datatable-roles-all" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>@lang('common.sl')</th>
                                        <th>@lang('branch_info.company_name')</th>
                                        <th>@lang('branch_info.branch_name')</th>
                                        <th>@lang('branch_info.branch_mobile')</th>
                                        <th>@lang('branch_info.branch_email')</th>
                                        <th>@lang('branch_info.status')</th>
                                        <th>@lang('branch_info.action')</th>
                                    </tr>
                                </thead>
                            </table>
                        </div> <!-- end all-->

                        <div class="tab-pane" id="roles-tab-deleted">
                            @php
                            use App\Models\branch_info;
                            use App\Models\company_info;
                            $data = branch_info::onlyTrashed()->get();
                            $sl = 1;
                            @endphp
                            <table id="alternative-page-datatable" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>@lang('common.sl')</th>
                                        <th>@lang('company_info.company_name')</th>
                                        <th>@lang('branch_info.branch_name')</th>
                                        <th>@lang('branch_info.branch_mobile')</th>
                                        <th>@lang('branch_info.action')</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @if($data)
                                    @foreach ($data as $v)
                                    <tr>
                                        <td>{{$sl++}}</td>
                                        <td>@if($v->company_id > 0)
                                            @php
                                            $company_info = company_info::where('id',$v->company_id)->first();
                                            @endphp

                                            @if(config('app.locale') == 'en') {{$company_info->company_name_en}} @elseif(config('app.locale') == 'en') {{$company_info->company_name_bn}} @endif

                                            @endif
                                        </td>
                                        <td>
                                            @if(config('app.locale') == 'en') {{$v->branch_name_en}} @elseif(config('app.locale') == 'en') {{$v->branch_name_bn}} @endif
                                        </td>
                                        <td>{{$v->branch_mobile}}</td>
                                        <td>{{$v->branch_email}}</td>
                                        <td>
                                            <a onclick="return confirmation();" class="btn btn-warning btn-sm" href="{{url('retrive_branch_info')}}/{{$v->id}}"><i class="fa fa-repeat"></i></a>
                                            <a onclick="return confirmation();" class="btn btn-danger btn-sm" href="{{url('branch_info_per_delete')}}/{{$v->id}}"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
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

    <script type="text/javascript">
        $(function () {
          var table = $('#datatable-roles-all').DataTable({
              processing: true,
              serverSide: true,
              ajax: "{{ route('branch_info.index') }}",
              columns: [
                    {data: 'sl', name: 'sl'},
                    {data: 'company_id', name: 'company_id'},
                    {data: 'branch_name', name: 'branch_name'},
                    {data: 'branch_mobile', name: 'branch_mobile'},
                    {data: 'branch_email', name: 'branch_email'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
              ]
          });
        });
    </script>

    <script>
        function Confirm()
        {
            if(confirm("Are You Sure ?"))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    </script>

    <script>
        function changeBranchStatus(id)
        {
            // alert(id);
            $.ajax({
                headers : {
                    'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                },

                url : '{{ url('changeBranchStatus') }}',

                type : 'POST',

                data : {id},

                success : function(data)
                {
                    // alert(data);
                    toastr.success('Status Updated', 'Success');
                }
            });
        }
      </script>


    @include('components.delete_script')
@endpush
